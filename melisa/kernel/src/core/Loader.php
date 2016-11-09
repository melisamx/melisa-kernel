<?php

namespace Melisa\core;

/* 
 * Loader libraries and logics
 * 
 */
class Loader
{
    
    public function libraries($library, $params =NULL) {
        
        return loader($library, 'libraries', $params);
        
    }
    
    public function logic($logic, $path = '') {
        
        return loader($logic, 'logics/' . $path);
        
    }
    
    public function orm($class) {
        
        static $load = NULL;
        
        if( !$load) {
            
            
            
        }
        
        $orm = loader($logic, 'logics/' . $path);
        
        $class;
        
    }
    
}
