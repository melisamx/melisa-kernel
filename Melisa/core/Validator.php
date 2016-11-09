<?php

namespace Melisa\core;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class Validator
{

    public function __construct() {
        
        logger()->debug(__CLASS__ . ' Class Initialized');
    
    }
    
    public function validateField($field, &$value = NULL, array &$model = []) {
        
        if( !isset($model['validator'])) {
            
            return logger()->error('Model invalid. No defined property validator', [
                'c'=>__CLASS__
            ]);
            
        }
        
        $validator = 'v' . ucfirst($model['validator']);
        
        if( !method_exists($this, $validator)) {
            
            return logger()->error('{c}. Validator {v} invalid not suported', [
                'c'=>__CLASS__,
                'v'=>$model['validator']
            ]);
            
        }
        
        logger()->debug('{c} Validating field {f} with the {v} validator', [
            'c'=>__CLASS__,
            'f'=>$field,
            'v'=>$model['validator']
        ]);
        
        $result = $this->{$validator}($field, $value, $model);
        
        if( !$result) {
            
            return FALSE;
            
        }
        
        return TRUE;
        
    }
    
    public function withModel(array &$fields = [], array &$model = []) {
        
        if( !v::countable()->validate($fields) &&  !v::countable()->validate($fields)) {
            
            return logger()->error('Fields and model invalid');
            
        }
        
        $flag = TRUE;
        
        foreach($fields as $field => &$value) {
            
            if( !isset($model['columns'][$field])) {
                
                $flag = logger()->error('{c}. Field {f} no exist in model', [
                    'c'=>__CLASS__,
                    'f'=>$field
                ]);
                break;
                
            }
            
            $result = $this->validateField($field, $value, $model['columns'][$field]);
            
            if( !$result) {
                
                $flag = FALSE;
                break;
                
            }
                
        }
        
        return $flag;
        
    }
    
    public function iterateExceptionValidation(&$validator, &$value) {
        
        $flag = TRUE;
        
        try {
            
            $result = $validator->assert($value);
            
        } catch (NestedValidationException $ex) {
            
            $result = $ex->getMessages();
            $flag = FALSE;
            
        }
        
        if( $flag) {
            
            return TRUE;
            
        }
        
        foreach($result as $result) {
            
            logger()->error($result);
            
        }
        
        return FALSE;
        
    }
    
    public function regex(&$value, $regexRequired, $regexNoRequired = NULL, $required = TRUE) {
        
        if( is_array($value) || is_object($value)) {
            
            return TRUE;
            
        }
        
        if( $required) {
            
            if(preg_match($regexRequired, $value) || $value === FALSE || $value === TRUE) {
                
                return TRUE;
                
            }
            
            return FALSE;
            
        }
        
        if( is_null($value)) {
            
            return TRUE;
            
        }
        
        if( is_null($regexNoRequired)) {
            
            $regexNoRequired = $regexRequired;
            
        }
        
        if(preg_match($regexNoRequired, $value)) {
            
            return TRUE;
            
        }
        
        return FALSE;
        
    }
    
    public function vNumberPositive($field, &$value, &$model) {
        
        $result = v::numeric()->positive()->validate($value);
        
        if( $result) {
            
            return TRUE;
            
        }
        
        if( $value == 0) {
            
            return TRUE;
            
        }
        
        return logger()->error('Value {v} in field "{f}" is not valid number positive', [
            'c'=>__CLASS__,
            'v'=>$value,
            'f'=>$field
        ]);
        
    }
    
    public function vPass($field, &$value, &$model) {
        
        $additionalChars = '!$%,.-()*+"\'';
        
        if( isset($model['additionalChars'])) {
            
            $additionalChars = $model['additionalChars'];
            
        }
        
        if( $model['required']) {
            
            $validator = v::allOf(
                v::alnum($additionalChars)->setName($field), 
                v::length(NULL, $model['size'])->setName($field), 
                v::notEmpty()->setName($field),
                v::noWhitespace()->setName($field)
            );
            
        } else {
            
            $validator = v::when(
                v::alnum($additionalChars)->setName($field),
                v::optional(v::length(NULL, $model['size'])),
                v::optional(v::alnum($additionalChars)->length(NULL, $model['size'])->noWhitespace())
            );
            
        }
        
        if( $this->iterateExceptionValidation($validator, $value)) {
            
            return TRUE;
            
        }
        
        return logger()->error('Value {v} in field "{f}" is not valid pass', [
            'c'=>__CLASS__,
            'v'=>$value,
            'f'=>$field
        ]);
        
    }
    
    public function vText($field, &$value, &$model) {
        
        $additionalChars = '!,.-()*+"\'';
        
        if( isset($model['additionalChars'])) {
            
            $additionalChars = $model['additionalChars'];
            
        }
        
        if( $model['required']) {
            
            $validator = v::allOf(
                v::alnum($additionalChars)->setName($field), 
                v::length(NULL, $model['size'])->setName($field), 
                v::notEmpty()->setName($field)
            );
            
        } else {
            
            $validator = v::when(
                v::alnum($additionalChars)->setName($field),
                v::optional(v::length(NULL, $model['size'])),
                v::optional(v::alnum($additionalChars)->length(NULL, $model['size']))
            );
            
        }
        
        if( $this->iterateExceptionValidation($validator, $value)) {
            
            return TRUE;
            
        }
        
        return logger()->error('Value {v} in field "{f}" is not valid text', [
            'c'=>__CLASS__,
            'v'=>$value,
            'f'=>$field
        ]);
        
    }
    
    public function vBoolean($field, &$value, &$model) {
        
        if( is_null($value)) {
            
            $value = FALSE;
            
        }
        
        $result = v::boolVal()->validate($value);
        
        if( $result) {
            
            return TRUE;
            
        }
        
        return logger()->error('{c}. Value {v} in field "{f}" is not valid boolean', [
            'c'=>__CLASS__,
            'v'=>$value,
            'f'=>$field
        ]);
        
    }
    
    public function vDateTime($field, &$value, &$model) {
        
        $dateFormat = 'Y-m-d H:i:s';
        
        if( isset($model['forma'])) {
            
            $dateFormat = $model['dateFormat'];
            
        }
        
        if( $model['required']) {
            
            $validator = v::date($dateFormat)->setName($field);
            
        } else {
            
            $validator = v::optional(v::date($dateFormat)->setName($field));
            
        }
        
        if( $this->iterateExceptionValidation($validator, $value)) {
            
            return TRUE;
            
        }
        
        return logger()->error('{c}. Value {v} in field "{f}" is not valid DateTime', [
            'c'=>__CLASS__,
            'v'=>$value,
            'f'=>$field
        ]);
        
    }
    
    public function vUuid($field, &$value, &$model) {
        
        $regex = '/^\{?[a-z0-9]{8}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{12}\}?$/';
        
        $result = $this->regex($value, $regex, NULL, $model['required']);
        
        if( $result) {
            
            return TRUE;
            
        }
        
        return logger()->error('Value {v} in field "{f}" is not valid uuid', [
            'c'=>__CLASS__,
            'v'=>$value,
            'f'=>$field
        ]);
        
    }
    
    public function vDouble($field, &$value, &$model) {
        
        if( $model['required']) {
            
            $validator = v::floatVal()->setName($field);
            
        } else {
            
            $validator = v::optional(v::floatVal()->setName($field));
            
        }
        
        if( $this->iterateExceptionValidation($validator, $value)) {
            
            return TRUE;
            
        }
        
        return logger()->error('Value {v} in field "{f}" is not valid double number', [
            'c'=>__CLASS__,
            'v'=>$value,
            'f'=>$field
        ]);
        
    }
    
}
