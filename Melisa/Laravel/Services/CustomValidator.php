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
    
}
