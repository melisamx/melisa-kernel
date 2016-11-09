<?php

namespace Melisa\core;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class InputValid
{
    
    public function make($model = NULL, array $fields = [], array $inputSet = []) {
        
        $input = input()->init($fields, $inputSet);
        
        if( $input === FALSE) {
            
            return FALSE;
            
        }
        
        $modelLoad = model()->get($model, TRUE);
        
        if( !$modelLoad) {
            
            return FALSE;
            
        }
        
        if( !validator()->withModel($input, $modelLoad)) {
            
            return FALSE;
            
        }
        
        return $input;
        
    }
    
}
