<?php

namespace Melisa\core;
use Melisa\laravel\Events as LaravelEvents;

class Events extends LaravelEvents
{
    
    public function __construct() {
        
        /* log init */
        log_message('debug',__CLASS__.' Class Initialized');
        
    }
    
    private static function load_listeners($eventos) {
        
        /* cache de carga de archivos */
        static $eventosRegistrados = array();
        static $eventosNoEncontrados = array();
        
        /* recorremos eventos a ejecutar */
        foreach ((array) $eventos as $evento) {
            
            /* verify anteriomente registrado */
            if(isset($eventosRegistrados[$evento]) || isset($eventosNoEncontrados[$evento])) {
                
                continue;
                
            }
            
            /* search class  */
            $pathEvent = loaderSearchFile($evento, 'events');
            
            /* verify  */
            if( $pathEvent) {
                
                /* registramos el registro de eventos para evitar duplicados */
                $eventosRegistrados[$evento] = TRUE;
                
            } else {
                
                $eventosNoEncontrados[$evento] = TRUE;
                
            }
            
        }
        
    }
    
    public function fire($eventos, $data = array(), $halt = FALSE) {
        
        /* load listeners */
        $this->load_listeners($eventos);
        
        /* debug */
        if(MYDEBUG) {
            
            /* verify  */
            if( !in_array($eventos, array(
                'core.message.add',
                'core.input.inyect_php',
            ))) {
                log_message('debug', 'Ejecutamos evento '.$eventos);
            }
            
        }
        
        /* reusamos logica fire */
        return parent::fire($eventos, $data, $halt);
        
    }
    
}
