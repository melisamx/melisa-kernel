<?php 

namespace Melisa\codeigniter;

/**
 * @author Luis Josafat Heredia Contreras
 */
class Router extends \CI_Router
{
    
    public function __construct() {
        
        parent::__construct();
        
    }
    
    public function _validate_request($segmentos) {
        
        /* verify segments */
        if( count($segmentos) == 0 ) {
            
            return $segmentos;
            
        }
        
        /* only app */
        if( file_exists(APPPATH . 'controllers/' . ucfirst($segmentos[0]) . '.php')) {
            
            return $segmentos;
            
        }
        
        // Is the controller in a sub-folder?
		if (is_dir(APPPATH . 'controllers/' . $segmentos[0])) {
            
            /* reusamos parent */
            return parent::_validate_request($segmentos);
            
        } else if( !is_dir(APPPATH . 'controllers/' . $segmentos[0])) {

            /* set segments */
            $segmentos = array(
                'actions',
                'index',
                $segmentos
            );

        }

        /* reusamos parent */
        return parent::_validate_request($segmentos);
        
    }
    
}
