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
        'input'=>'Input',
        'database'=>'Database',
        'view'=>'View',
        'views'=>'Views',
        'output'=>'Output',
        'msg'=>'Messages',
        'event'=>'Events',
        'load'=>'Loader',
        'logger'=>'Logging',
        'model'=>'Models',
        'fs'=>'FileSystem',
        'validator'=>'Validator',
        'inputValid'=>'InputValid',
        'array'=>'ArrayHelper',
        'userAgent'=>'UserAgent',
        'string'=>'StringHelper'
    ];
    
    public function get($name)
    {        
        if( isset($this->services[$name])) {            
            return $this->createInstance($name);            
        }
        
        exit('service no suport ' . $name);        
    }
    
    public function createInstance($name)
    {        
        static $instances = [];
        
        if( isset($instances[$name])) {            
            return $instances[$name];            
        }
        
        $instanceName = __NAMESPACE__ . '\\' . $this->services[$name];        
        $instances [$name] = new $instanceName();        
        return $instances [$name];        
    }
    
}
