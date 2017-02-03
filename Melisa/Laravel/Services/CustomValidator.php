<?php namespace Melisa\Laravel\Services;

use Illuminate\Validation\Validator;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class CustomValidator extends Validator
{
    
    public function validateBoolean($attribute, $value) {
        
        /* sencha send true and false */
        $acceptable = [true, false, 0, 1, '0', '1', 'true', 'false'];

        return in_array($value, $acceptable, true);
        
    }
    
    public function validateSort($field, $value, $parameters, $validator)
    {
        
        $this->requireParameterCount(1, $parameters, 'sort');
        
        $fieldsSort = json_decode($value);
        
        foreach($fieldsSort as $fieldSort) {
            
            if( !isset($fieldSort->property, $fieldSort->direction)) {
                $validator->errors()->add($field, 'sort.json.invalid');
                return false;
            }
            
            if( !in_array($fieldSort->property, $parameters, true)) {
                $validator->errors()->add($field, 'sort.field.invalid');
                return false;
            }
            
            if( !in_array($fieldSort->direction, ['ASC', 'DESC'], true)) {
                $validator->errors()->add($field, 'sort.direction.invalid');
                return false;
            }
            
        }
        
        return true;
        
    }
    
    public function validateAlphaspaces($attribute, $value, $params)
    {
        return preg_match('/^[\pL\s]+$/u', $value);
    }
    
}
