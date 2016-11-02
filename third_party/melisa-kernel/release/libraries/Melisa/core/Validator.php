<?php

namespace Melisa\core;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class Validator extends Base
{


    public function __construct() {
        
        log_message('debug', __CLASS__ . ' Class Initialized');
    
    }
    
    public function validateField($field, &$value = NULL, array &$model = []) {
        
        if( !isset($model['validator'])) {
            
            return $this->log()->error('Model invalid. No defined property validator', [
                'c'=>__CLASS__,
            ]);
            
        }
        
        $validator = 'v' . ucfirst($model['validator']);
        $errorMessage = 'Value in field {f} is invalid';
        
        if( !method_exists($this, $validator)) {
            
            return $this->log()->error('{c}. Validator {v} invalid not suported', [
                'c'=>__CLASS__,
                'v'=>$model['validator']
            ]);
            
        }
        
        $this->log()->debug('{c}. Validating field {f} with the {v} validator', [
            'c'=>__CLASS__,
            'f'=>$field,
            'v'=>$model['validator']
        ]);
        
        $result = $this->{$validator}($field, $value, $model, $errorMessage);
        
        if( !$result) {
            
            return $this->log()->error('{c}. ' . $errorMessage, [
                'c'=>__CLASS__,
                'f'=>$field,
                'v'=>empty($value) ? '"NULL or []' : $value
            ]);
            
        }
        
        return TRUE;
        
    }
    
    public function validateWithModel(array &$fields = [], array &$model = []) {
        
        if( !v::countable()->validate($fields) &&  !v::countable()->validate($fields)) {
            
            return $this->log()->error('Fields and model invalid');
            
        }
        
        $flag = TRUE;
        
        foreach($fields as $field => &$value) {
            
            if( !isset($model['columns'][$field])) {
                
                $flag = $this->log()->error('Field {f} no exist in model', [
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
            
            $this->log()->error($result);
            
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
    
    public function vNumberPositive($field, &$value, &$model, &$errorMessage) {
        
        $result = v::numeric()->positive()->validate($value);
        
        if( $result) {
            
            return TRUE;
            
        }
        
        $errorMessage = 'Value {v} in field "{f}" is not valid number positive';
        return FALSE;
        
    }
    
    public function vText($field, &$value, &$model, &$errorMessage) {
        
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
        
        $errorMessage = 'Value {v} in field "{f}" is not valid text';
        return FALSE;
        
    }
    
    public function vBoolean($field, &$value, &$model, &$errorMessage) {
        
        if( is_null($value)) {
            
            $value = FALSE;
            
        }
        
        $result = v::boolVal()->validate($value);
        
        if( $result) {
            
            return TRUE;
            
        }
        
        $errorMessage = 'Value {v} in field "{f}" is not valid boolean';
        return FALSE;
        
    }
    
    public function vDateTime($field, &$value, &$model, &$errorMessage) {
        
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
        
        $errorMessage = 'Value {v} in field "{f}" is not valid DateTime';
        return FALSE;
        
    }
    
    public function vUuid($field, &$value, &$model, &$errorMessage) {
        
        $regex = '/^\{?[a-z0-9]{8}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{12}\}?$/';
        
        $result = $this->regex($value, $regex, NULL, $model['required']);
        
        if( $result) {
            
            return TRUE;
            
        }
        
        $errorMessage = 'Value {v} in field "{f}" is not valid uuid';
        return FALSE;
        
    }
    
    public function vDouble($field, &$value, &$model, &$errorMessage) {
        
        if( $model['required']) {
            
            $validator = v::floatVal()->setName($field);
            
        } else {
            
            $validator = v::optional(v::floatVal()->setName($field));
            
        }
        
        if( $this->iterateExceptionValidation($validator, $value)) {
            
            return TRUE;
            
        }
        
        $errorMessage = 'Value {v} in field "{f}" is not valid double number';
        return FALSE;
        
    }
    
}
