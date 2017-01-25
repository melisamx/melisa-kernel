<?php namespace Melisa\Laravel\Http\Requests;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class WithFilter extends Generic
{
    
    public function __construct() {
        
        parent::__construct();
        
        $rules = $this->rulesFilters;
        
        validator()->extend('filter', function($field, $value, $parameters, $validator) use ($rules) {
            
            $filters = json_decode($value);
            $flag = true;

            foreach($filters as $filter) {

                if( !isset($filter->property, $filter->value)) {
                    
                    $flag = false;                    
                    $validator->errors()->add($field, 'filter.json.invalid');
                    break;

                }

                if( empty($parameters)) {

                    continue;

                }

                if( !in_array($filter->property, $parameters, true)) {

                    $validator->errors()->add($field, 'filter.not.allowed');
                    $flag = false;
                    break;

                }
                
                if( is_null($rules)) {
                    
                    continue;
                    
                }
                
                $validatorProperty = \Validator::make([
                    $filter->property => $filter->value
                ], $rules);
                
                $flag = $validatorProperty->passes();
                
                if( $flag) {
                    
                    continue;
                    
                }
                
                foreach($validatorProperty->errors()->all() as $error) {
                    
                    $validator->errors()->add($field . '.' . $filter->property, $error);
                    
                }
                
                break;

            }

            if( !$flag) {

                return false;
            }

            return true;
        
        });
        
    }
    
    public function allValid() {
        
        $input = $this->only(array_keys($this->rules));
        
        if( !isset($input['filter'])) {            
            return $input;            
        }
        
        $filters = json_decode($input['filter']);
        
        $this->merge([
            'filter'=>$filters
        ]);
        
        return parent::allValid();
        
    }
    
}
