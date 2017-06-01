<?php

use Melisa\core\ServiceProvider;

/**
 * 
 * @author Luis Josafat Heredia Contreras
 */
if( !function_exists('melisa')) {
    
    function melisa($name)
    {        
        static $serviceProvider = NULL;
        
        if( !$serviceProvider) {            
            $serviceProvider = new ServiceProvider();            
        }
        
        return $serviceProvider->get($name);        
    }
    
}
