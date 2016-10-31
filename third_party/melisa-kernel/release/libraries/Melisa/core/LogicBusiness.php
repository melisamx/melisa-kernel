<?php

namespace Melisa\core;

class LogicBusiness extends Base
{
    
    public function db() {
        
        return get_instance()->app->load()
            ->libraries(__NAMESPACE__ . '\Database');
        
    }
    
    public function load() {
        
        return get_instance()->app->load();
        
    }
    
    public function input() {
        
        return $this->load()->libraries(__NAMESPACE__ . '\Input');
        
    }
    
}
