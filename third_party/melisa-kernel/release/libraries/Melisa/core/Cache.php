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
        get_instance()->abs->driver_is_load();
        
    }
    
    public function get($key) {
        
        return get_instance()->abs->cache_get($key);
        
    }
    
    public function save($key, $data) {
        
        return get_instance()->abs->cache_save($key, $data);
        
    }
    
    public function delete($key, $multi = FALSE) {
        
        return get_instance()->abs->cache_delete($key, $multi);
        
    }
    
}
