<?php

namespace Melisa\Laravel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Melisa\Laravel\Http\Requests\RequestInterface;

/**
 * 
 * @author Luis Josafat Heredia Contreras
 */
class Generic extends FormRequest implements RequestInterface
{
    
    public $keyAction = true;
    protected $rules = [];
    
    public function __construct(Factory $factory)
    {        
        parent::__construct();
        
        if (method_exists($this, 'applicableValidations')) {
            $this->useCustomValidations($factory, $this->applicableValidations());
        }
        
        $me = $this;
        
        validator()->extend('xss', function($field, $value, $parameters, $validator) use($me) {
            
            $value = app('xss')->xss_clean($value);
            
            $me->merge([
                $field=>$value
            ]);
            
            return true;
            
        });        
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->keyAction;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {        
        return $this->rules;        
    }
    
    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array  $errors
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {        
        return new JsonResponse([
            'success'=>false,
            'errors'=>[
                $errors
            ]
        ], 422);        
    }
    
    public function allValid()
    {        
        return $this->only(array_keys($this->rules()));        
    }
    
    private function useCustomValidations($factory, $validations)
    {
        $validations->each(function ($validation) use ($factory) {
            $factory->extend($validation->name(), $validation->test(), $validation->errorMessage());
        });
    }
    
    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->getMessageBag()->toArray();
        $logger = melisa('logger');
        foreach ($errors as $field=>$messages) {
            foreach($messages as $message) {
                if( is_array($message)) {
                    $logger->error('Campo ' .  $field . ' invalido. ' .$message['message']);
                } else {
                    $logger->error('Campo ' . $field . ' invalido. ' . $message);
                }
            }
        }
        
        throw new HttpResponseException(response()->data(false, 422));
    }
    
}
