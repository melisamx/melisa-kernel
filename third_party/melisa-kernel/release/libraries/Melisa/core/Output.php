<?php 

namespace Melisa\core;

/**
 * Colect response append in result
 *
 * @author Luis Josafat Heredia Contreras
 */
class Output
{
    
    private $response = [];
    
    public function __construct() {
        
        logger()->debug( __CLASS__ . ' Class Initialized');
        
    }
    
    public function get($item = NULL) {
        
        if( is_null($item)) {
            
            return $this->response;
            
        }
        
        if( !isset($this->response[$item])) {
            
            return NULL;
            
        }
        
        return $this->response[$item];
        
    }
    
    public function add($item, $value, $combinar = FALSE) {
        
        if( isset($this->response[$item])) {
            
            $this->response[$item] = $value;
            return $this;
            
        }
        
        if( !$combinar) {
            
            $this->response[$item] = $value;
            return $this;
            
        }
        
        /* set value combinados */
        $this->response[$item] = array_default($value, $this->response[$item]);
        
        return $this;
        
    }
    
}
