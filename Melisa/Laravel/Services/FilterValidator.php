<?php namespace Melisa\Laravel\Services;

use Illuminate\Validation\Validator;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class FilterValidator extends Validator
{
    
    public function validateFilter($attribute, $value, $parameters, $validator) {
        exit(dd($validator));
        $filters = json_decode($value);
        $flag = true;
        
        foreach($filters as $filter) {
            
            if( !isset($filter->property, $filter->value)) {

                $flag = false;
                break;

            }
            
            if( empty($parameters)) {
                
                continue;
                
            }

            if( !in_array($filter->property, $parameters, true)) {

                $flag = false;
                break;

            }

        }
        
        if( !$flag) {

            return false;
        }

        return $flag;
        
    }
    
}
