<?php

namespace Melisa\application\validations;

class Base
{
    
    public function __construct() {
        
        log_message('debug', __CLASS__ . ' Class Initialized');
        
    }
    
    public function init($config = []) {
        
        $ci = get_instance();
        
        if( !$this->isValidRouterMethod($ci)) {
            
            return FALSE;
            
        }
        
        if( !$this->isRequestOnlyLocal($config, $ci)) {
            
            return FALSE;
            
        }
        
        if( !$this->userAgentIsValid($ci)) {
            
            return FALSE;
            
        }
        
        if( !$this->isRequestOnlyCli($config, $ci)) {
            
            return FALSE;
            
        }
        
        return TRUE;
        
    }
    
    public function isRequestOnlyCli(&$config, &$ci) {
        
        if( !$config['request.only_cli']) {
            
            return TRUE;
            
        }
        
        /* get del config el tipo de UA */
        $ua = $ci->abs->config_get('app.ua');
        
        if( $ua['tipo'] != 'cli') {
            
            message([
                'debug'=>TRUE,
                'file'=>__FILE__,
                'line'=>__LINE__,
                'msg'=>'Solo se permiten peticiones CLI'
            ]);
            
            return FALSE;

        }

        /* load library cli */
        $ci->abs->library_is_load('Cli');

        /* load helper */
        $ci->abs->load_helper('class_reflection_helper');

        /* create listener */
        Event()->listen('core.message.add', function($message) use ($ci) {

            switch ($message['type']) {

                case 'debug':
                    $color='yellow';
                    break;
                default:
                    $color='red';
                    break;
            }

            /* verify color */
            if(isset($message['color'])) {

                $color = $message['color'];

            }

            /* display mensaje en consola */
            $ci->cli->write($message['msg'], $color);

        });
        
        return TRUE;
        
    }
    
    public function userAgentIsValid(&$ci) {
        
        /* get del config el tipo de UA */
        $ua = $ci->abs->config_get('app.ua');
        
        /* verificamos si el acceso es por algun browser */
        if($ua['tipo'] != 'browser') {
            
            return TRUE;
            
        }
        
        /* verificamos si esta en la lista de user agents obsoletos */
        if( !in_array($ua['nombre'], ['Internet Explorer'])) {
            
            return TRUE;

        }
        
        /* verificamos si la version esta en la version considerada como obsoleta */
        if( !in_array($ua['version'], ['6.0', 7])) {
            
            return TRUE;

        }
        
        message([
            'file'=>__FILE__,
            'line'=>__LINE__,
            'msg'=>'Using the application is only supported by modern web browsers'
        ]);

        return FALSE;
        
    }
    
    public function isRequestOnlyLocal(&$config, &$ci) {
        
        if( !$config['request.only_local']) {
            
            return TRUE;
            
        }
        
        if($ci->input->ip_address() == '127.0.0.1') {
            
            return TRUE;

        }
        
        message([
            'file'=>__FILE__,
            'line'=>__LINE__,
            'msg'=>'Using the application is only supported by local requests: '.
                $ci->input->ip_address()
        ]);

        return FALSE;
            
    }
    
    public function isValidRouterMethod(&$ci) {
        
        if( !method_exists($ci, $ci->abs->router_get_metodo())) {
            
            if( !$ci->abs->env_get()) {
                
                exit;
                
            }
            
            exit('Invalid method in controller');
            
        }
        
        return TRUE;
        
    }
    
}
