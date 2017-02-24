<?php namespace Melisa\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseMacroServiceProvider extends ServiceProvider
{
    
    public function responseCreate($value) {
        
        $data = $this->addDefaultResult($value);        
        
        $this->addBenchMark($data);

        if( is_array($value)) {
            $data += $value;
        } else {
            $data ['id']= $value;
        }

        $response = $this->addMessages($data);

        return $this->responseJson($value, $response);
        
    }
    
    public function responseData($value) {
        
        $data = $this->addDefaultResult($value);        
        
        $this->addBenchMark($data);
        
        if( $value) {
            $data ['data']= $value;
        }

        $response = $this->addMessages($data);

        return $this->responseJson($value, $response);
        
    }
    
    public function responsePaging($value) {
        
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
        
    }
    
    public function responseJson(&$value, &$response) {
        
        if( $value) {
            return Response::json($response);
        }

        return Response::json($response)->header('Content-Status', 400);
        
    }
    
    public function addDefaultResult(&$value) {
        
        return [
            'success'=>$value ? true : false,
        ];
        
    }
    
    public function addMessages(&$data) {
        
        $messages = melisa('msg')->get();
        
        return melisa('array')->mergeDefault($messages, $data);
        
    }
    
    public function addBenchMark(&$data) {
        
        if( env('APP_ENV') === 'local') {                
            $data ['benchmark']= round(memory_get_usage() / 1024 / 1024, 2) . 'MB';
        }
        
    }
    
}
