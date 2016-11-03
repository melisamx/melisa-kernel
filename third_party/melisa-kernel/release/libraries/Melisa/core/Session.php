<?php 

namespace Melisa\core;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class Session
{
    
    protected $session = [];
    
    public function __construct() {
        
        logger()->debug(__CLASS__ . ' Class Initialized');
        
    }

    public function save($data) {
        
        $this->session = $data;
        
    }
    
    public function get($item = NULL) {
        
        if( is_null($item)) {
            
            return $this->session;
            
        }
        
        return isset($this->session[$item]) ? 
            $this->session[$item] : FALSE;
        
    }
    
}
