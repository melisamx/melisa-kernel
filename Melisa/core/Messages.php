<?php

namespace Melisa\core;

class Messages
{
        
    public function add($input)
    {        
        $message = melisa('array')->mergeDefault($input, [
            'type'=>'error',
            'line'=>FALSE,
            'log'=>TRUE,
            'file'=>FALSE,
            'message'=>''
        ]);
        
        /* unset variables de mas */
        if( !$message['file']) unset($message['file']);
        if( !$message['line']) unset($message['line']);
        unset($message['log']);
        
        if(env('APP_ENV') != 'local') {            
            unset($message['line'], $message['file'], $message['log']);            
        }
        
        $this->addMessage($message);        
    }
    
    public function get()
    {        
        return $this->addMessage(NULL, TRUE);        
    }
    
    private function addMessage($message, $get = FALSE)
    {        
        static $messages = array();
        static $count = 0;
        
        if($get) {            
            /* verify enviroment, delete message debug */
            if(env('APP_ENV') != 'local' && isset($messages['d'])) {                
                unset($messages['d']);                   
            }
            
            return $messages;            
        }
        
        if( $count > 50) {            
            $messages = [];
            $count = 0;            
        }
        
        switch ($message['type']) {
            
            case 'debug':
                $type = 'debug';
                break;
            
            case 'warning':
                $type = 'warning';
                break;
            
            case 'benchmark':
                /* benchmark points ya que bm es usado por el sistema */
                $type = 'bmp';
                break;
            default:
                $type = 'errors';
                break;
        }
        
        unset($message['type']);        
        /* add message */
        $messages[$type][] = $message;        
    }
    
}
