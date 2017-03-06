<?php namespace Melisa\Laravel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class Generic extends FormRequest
{
    
    public $keyAction = true;
    protected $rules = [];
    
    public function __construct() {
        
        parent::__construct();
        
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
    
}
