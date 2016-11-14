<?php

namespace Melisa\core\orm;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait ErrorHumanTrait
{
    
    public static function errorHuman($message = NULL, $errorInfo = NULL, &$input = []) {
        
        if( is_null($message)) {
            
            return 'Error grave';
            
        }
        
        if( str_contains($message, [
            'Duplicate entry'
        ])) {
            
            return static::duplicateKey($message, $errorInfo, $input);
            
        }
        
        return $message;
        
    }
    
    public static function duplicateKey(&$message, &$errorInfo, &$input) {
        
        $matches = [];
        preg_match("/'(.*)' for key '(\w*)_UNIQUE+/m", $message, $matches);
        
        if( !isset($matches[1])) {
            
            return 'Duplicate key';
            
        }
        
        return melisa('array')->interpolate('Duplicate value "{v}" in field {f}', [
            'v'=>$matches[1],
            'f'=>$matches[2]
        ]);
        
    }
    
}
