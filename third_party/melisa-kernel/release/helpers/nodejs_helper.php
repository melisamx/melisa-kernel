<?php 

if( !function_exists('nodejs_send')) {
    
    function nodejs_send($serverName, $message, $config = NULL) {
        
        return loader('Mynodejs', 'libraries')    
            ->send($serverName, $message, $config);

    }
    
}

if( !function_exists('nodejs_disconnect')) {
    
    function nodejs_disconnect($serverName) {
        
        return loader('Mynodejs', 'libraries')    
            ->disconnect($serverName);

    }
    
}
