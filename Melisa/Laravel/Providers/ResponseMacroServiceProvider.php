<?php

namespace Melisa\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Contracts\Validation\Validator;

/**
 * 
 * @author Luis Josafat Heredia Contreras
 */
class ResponseMacroServiceProvider extends ServiceProvider
{
    
    public function responseCreate($value)
    {        
        $data = $this->addDefaultResult($value);        
        
        $this->addBenchMark($data);

        if( $value) {
            $data ['data']= $value;
        }

        $response = $this->addMessages($data);

        return $this->responseJson($value, $response, 201);        
    }
    
    public function responseData($value, $status = 200)
    {
        $data = $this->addDefaultResult($value);        
        
        $this->addBenchMark($data);
        
        if( $value) {
            $data ['data']= $value;
        }

        $response = $this->addMessages($data);
        return $this->responseJson($value, $response, $status);        
    }
    
    public function responsePaging($value)
    {        
        $data = $this->addDefaultResult($value);        
        
        $this->addBenchMark($data);
        
        if( $value) {
            $data += $value;
        }

        $response = $this->addMessages($data);

        return $this->responseJson($value, $response);        
    }
    
    public function boot()
    {        
        Response::macro('create', [$this, 'responseCreate']);
        Response::macro('data', [$this, 'responseData']);
        Response::macro('paging', [$this, 'responsePaging']);        
        Response::macro('unauthenticated', [$this, 'responseUnauthenticated']);        
        Response::macro('unauthorized', [$this, 'responseUnauthorized']);
        Response::macro('validationException', [$this, 'responseValidationException']);
    }
    
    public function responseUnauthenticated($message)
    {
        $data = $this->addDefaultResult($message);        
        $this->addBenchMark($data);
        $response = $this->addMessages($data);
        return Response::json($response, 401);
    }
    
    public function responseUnauthorized($message)
    {
        $data = $this->addDefaultResult($message);        
        $this->addBenchMark($data);
        $response = $this->addMessages($data);
        return Response::json($response, 401);
    }
    
    public function responseJson(&$value, &$response, $status = 200)
    {        
        if( $value) {
            return Response::json($response, $status);
        }

        return Response::json($response, $status);        
    }
    
    public function addDefaultResult(&$value)
    {        
        return [
            'success'=>$value ? true : false,
        ];        
    }
    
    public function addMessages(&$data)
    {        
        $messages = app('messages')->getAllTypes();        
        return melisa('array')->mergeDefault($messages, $data);
    }
    
    public function addBenchMark(&$data)
    {        
        if( env('APP_ENV') === 'local') {                
            $data ['benchmark']= round(memory_get_usage() / 1024 / 1024, 2) . 'MB';
        }        
    }
    
    public function responseValidationException(Validator $validator)
    {
        $errors = $validator->getMessageBag()->toArray();
        $messages = app('messages');
        
        foreach($errors as $field => $fieldErrors) {
            foreach($fieldErrors as $message) {
                if( isset($validator->errorCode) && isset($validator->errorCode[$field])) {
                    $messages->add([
                        'code'=>$validator->errorCode[$field],
                        'message'=>"Field $field : $message"
                    ]);
                } else {
                    $messages->add([
                        'message'=>"Field $field : $message"
                    ]);
                }
            }
        }
        
        $value = false;
        $data = $this->addDefaultResult($value);        
        $this->addBenchMark($data);
        $response = $this->addMessages($data);
        return $this->responseJson($value, $response, 422);
    }
    
}
