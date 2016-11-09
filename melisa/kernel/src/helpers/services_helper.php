<?php 

use Melisa\core\ServiceProvider;

if( !function_exists('service')) {
    
    function service($name) {
        
        static $serviceProvider = NULL;
        
        if( !$serviceProvider) {
            
            $serviceProvider = new ServiceProvider();
            
        }
        
        return $serviceProvider->get($name);
        
    }
    
}

if( !function_exists('msg')) {
    
    function msg() {
        
        return service('msg');
        
    }
    
}

if( !function_exists('uuid')) {
    
    function uuid() {
        
        return service('uuid');
        
    }
    
}

if( !function_exists('input')) {
    
    function input() {
        
        return service('input');
        
    }
    
}

if( !function_exists('app')) {
    
    function app() {
        
        return get_instance()->app;
        
    }
    
}

if( !function_exists('fs')) {
    
    function fs() {
        
        return service('fs');
        
    }
    
}

if( !function_exists('model')) {
    
    function model() {
        
        return service('model');
        
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

if( !function_exists('views')) {
    
    function views() {
        
        return service('views');
        
    }
    
}

if( !function_exists('output')) {
    
    function output() {
        
        return service('output');
        
    }
    
}

if( !function_exists('validator')) {
    
    function validator() {
        
        return service('validator');
        
    }
    
}

if( !function_exists('inputValid')) {
    
    function inputValid() {
        
        return service('inputValid');
        
    }
    
}
