<?php

namespace Melisa\core;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class Cache
{
    
    public function __construct() {
        
        logger()->debug(__CLASS__.' Class Initialized');
        
    }
    
    public function get($key) {
        
        $ci = &get_instance();
        $ci->abs->driver_is_load();
        
        return $ci->abs->cache_get($key);
        
    }
    
    public function save($key, $data) {
        
        $ci = &get_instance();
        $ci->abs->driver_is_load();
        
        return $ci->abs->cache_save($key, $data);
        
    }
    
}
