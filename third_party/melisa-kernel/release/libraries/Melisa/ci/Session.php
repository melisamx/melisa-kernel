<?php 

namespace Melisa\ci;

/**
 * @author Luis Josafat Heredia Contreras
 */
class Session extends \CI_Session
{
    
    public function __construct() {
        
        /* verify cli request */
        if (get_instance()->input->is_cli_request()) {
            
            return;
            
        }

        parent::__construct();
        
    }
    
}
