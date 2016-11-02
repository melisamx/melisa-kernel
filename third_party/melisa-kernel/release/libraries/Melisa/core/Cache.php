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
        
        log_message('debug',__CLASS__.' Class Initialized');
        
    }
    
    static public function getItem($item) {
        
        $ci = &get_instance();
        $ci->abs->driver_is_load();
        
        return $ci->abs->cache_get($item);
        
    }
    
}
