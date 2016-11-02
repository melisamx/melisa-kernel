<?php

namespace Melisa\core;

/**
 * Service Provider simple
 *
 * @author Luis Josafat Heredia Contreras
 */
class ServiceProvider
{
    
    protected $services = [
        'cache'=>'Cache',
        'database'=>'Database',
        'view'=>'View',
        'msg'=>'Messages',
        'event'=>'Events',
        'load'=>'Loader',
        'logger'=>'Logging'
    ];

    public function __construct() {
        
        log_message('debug', __CLASS__ . ' Class Initialized');
        
    }
    
    public function get($name) {
        
        if( isset($this->services[$name])) {
            
            return $this->createInstance($name);
            
        }
        
        exit('service no suport' . $name);
        
    }
    
    public function createInstance($name) {
        
        return loader(__NAMESPACE__ . '\\' . $this->services[$name], 'libraries');
        
    }
    
}
