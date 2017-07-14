<?php

namespace Melisa\Laravel\Http\Validations;

/**
 * Json records validation
 *
 * @author Luis Josafat Heredia Contreras
 */
class JsonRecordsValidation extends CustomValidation
{
    
    protected $name = 'custom_json_records';
    protected $errorMessage = 'Custom error message';
    protected $messages = [];

    public function name()
    {
        return $this->name;
    }

    public function test()
    {
        $rules = $this->rules;
        $messages = $this->messages;
        return function ($name, $value, $params, $validator) use ($rules, $messages) {
            
            $input = json_decode($value, true);
            
            if(empty($input)) {
                return isset($params[0]) ? false : true;
            }
            
            if( is_null($input)) {
                return false;
            }
            
            foreach($input as $record) {
                
                $validation = \Validator::make($record, $rules, $messages);
                
                if( $validation->passes()) {
                    continue;
                }
                
                foreach($validation->errors()->all() as $error) {
                    $validator->errors()->add('record.invalid', $error);                    
                }
                
                return false;
            }
            
            return true;
        };
    }

    public function errorMessage()
    {
        return $this->errorMessage;
    }
    
}
