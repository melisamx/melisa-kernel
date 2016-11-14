<?php

use Melisa\core\ServiceProvider;

if( !function_exists('melisa')) {
    
    function melisa($name) {
        
        static $serviceProvider = NULL;
        
        if( !$serviceProvider) {
            
            $serviceProvider = new ServiceProvider();
            
        }
        
        return $serviceProvider->get($name);
        
    }
    
}
