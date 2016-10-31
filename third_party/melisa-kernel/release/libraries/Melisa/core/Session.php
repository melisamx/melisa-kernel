<?php 

namespace Melisa\core;

use Melisa\core\Base;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class Session extends Base
{
    
    protected $session = [];

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
