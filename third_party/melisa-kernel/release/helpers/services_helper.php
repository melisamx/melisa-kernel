<?php

if( !function_exists('service')) {
    
    function service($name) {
        
        static $serviceProvider = NULL;
        
        if( !$serviceProvider) {
            
            $serviceProvider = loader('Melisa/core/ServiceProvider', 'libraries');
            
        }
        
        return $serviceProvider->get($name);
        
    }
    
}

if( !function_exists('msg')) {
    
    function msg() {
        
        return service('msg');
        
    }
    
}

if( !function_exists('models')) {
    
    function models() {
        
        return service('models');
        
    }
    
}

if( !function_exists('load')) {
    
    function load() {
        
        return service('load');
        
    }
    
}

if( !function_exists('logger')) {
    
    function logger() {
        
        return service('logger');
        
    }
    
}

if( !function_exists('event')) {
    
    function event() {
        
        return service('event');
        
    }
    
}

if( !function_exists('cache')) {
    
    function cache() {
        
        return service('cache');
        
    }
    
}

if( !function_exists('log')) {
    
    function log() {
        
        return service('log');
        
    }
    
}

if( !function_exists('database')) {
    
    function database() {
        
        return service('database');
        
    }
    
}

if( !function_exists('view')) {
    
    function view() {
        
        return service('view');
        
    }
    
}
