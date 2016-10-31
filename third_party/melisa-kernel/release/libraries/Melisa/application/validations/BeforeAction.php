<?php

namespace Melisa\application\validations;
use Melisa\Application as App;

class BeforeAction
{
    
    private $app = NULL;
    
    public function __construct(App $application) {
        
        log_message('debug', __CLASS__ . ' Class Initialized');
        $this->app = $application;
        
    }
    
    public function init(&$config) {
        
        $ci = &get_instance();
        
        if( !$this->isValidAutentificationHttpBasic($config, $ci)) {
            
            return FALSE;
            
        }
        
        return TRUE;
        
    }
    
    public function isValidAutentificationHttpBasic(&$config, &$ci) {
        
        if( $config['autentificacion.type'] != 'basic') {
            
            return TRUE;
            
        }
        
        $okAuthBasic = Event()->fire('core.autentificacion.httpBasic', [
            'shared'=>&$config
        ]);

        if( in_array(FALSE, $okAuthBasic)) {

            return FALSE;

        }
        
        return TRUE;
        
    }
    
}
