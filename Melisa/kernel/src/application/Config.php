<?php

namespace Melisa\application;

class Config
{
    
    public function __construct() {
        
        logger()->debug( __CLASS__ . ' Class Initialized');
        get_instance()->abs->driver_is_load();
        
    }
    
    public function init() {
        
        $config = $this->getBase();
        
        if( !$config) {
            
            return FALSE;
            
        }
        
    }
    
    public function getBase() {
        
        $config = get_instance()->abs->cache_get('system.config.app');
        
        if( !$config) {
            
            $config = loader();
            
        }
        
    }
    
}
