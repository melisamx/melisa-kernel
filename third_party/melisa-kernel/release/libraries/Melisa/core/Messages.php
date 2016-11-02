<?php

namespace Melisa\core;

class Messages
{
    
    public function __construct() {
        
        log_message('debug', __CLASS__ . ' Class Initialized');
        
    }
    
    public function add($input) {
        
        $message = array_default($input, [
            'type'=>'error',
            'line'=>FALSE,
            'log'=>TRUE,
            'file'=>FALSE,
            'message'=>''
        ]);
        
        if($message['log']) {
            
            log_message($message['type'], $message['message']);
            
        }
        
        /* unset variables de mas */
        if( !$message['file']) unset($message['file']);
        if( !$message['line']) unset($message['line']);
        if( !$message['log']) unset($message['log']);
        
        if(ENVIRONMENT != 'development') {
            
            unset($message['line'], $message['file'], $message['log']);
            
        }
        
        $this->addMessage($message);
        
    }
    
    public function get() {
        
        return $this->addMessage(NULL, TRUE);
        
    }
    
    private function addMessage($message, $get = FALSE) {
        
        static $messages = array();
        static $count = 0;
        
        if($get) {
            
            /* verify enviroment, delete message debug */
            if(ENVIRONMENT != 'development' && isset($messages['d'])) {
                
                unset($messages['d']);
                   
            }
            
            return $messages;
            
        }
        
        if( $count > 50) {
            
            $messages = [];
            $count = 0;
            
        }
        
        /* agrupamos los mensajes por type */
        switch ($message['type']) {
            
            case 'debug':
                $tipo = 'd';
                break;
            
            case 'warning':
                $tipo = 'w';
                break;
            
            case 'benchmark':
                /* benchmark points ya que bm es usado por el sistema */
                $tipo = 'bmp';
                break;
            default:
                $tipo = 'e';
                break;
        }
        
        /* exec event */
        Event()->fire('core.message.add', [
            $message
        ]);
        
        unset($message['type']);
        
        /* add message */
        $messages[$tipo][] = $message;
        
    }
    
}
