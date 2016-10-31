<?php 

if( !function_exists('message')) {
    
    function message($config = NULL) {
        
        static $classMessage = NULL;
        
        if( !MYDEBUG) {
            
            /* verify error */
            if( isset($config['type']) && $config['type']=='debug') {
                
                return;
                
            }
            
        }
        
        if( is_null($classMessage)) {
            
            $classMessage = &loader('Melisa/core/Messages', 'libraries');
            
        }
        
        if( is_null($config)) {
            
            return $classMessage->get();
            
        }
        
        /* add mensaje */
        $classMessage->add($config);

    }
    
}
