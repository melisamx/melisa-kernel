<?php 

namespace Melisa\core;
use Psr\Log\LoggerInterface as PsrLoggerInterface;

/* 
 * Clase base que usaran la mayoria de las clase
 * 
 */
class Base
{
    
    public function log(PsrLoggerInterface $logger = NULL) {
        
        static $log = NULL;
        
        if( $log) {
            
            return $log;
            
        }
        
        if( is_null($logger)) {
            
            $log = get_instance()
                ->app
                ->load()
                ->libraries(__NAMESPACE__ . '\\Logging');
            
        } else {
            
            $log = $logger;
            
        }
        
        return $log;
        
    }
    
    public function event() {
        
        return Event();
        
    }
    
    public function getApp() {
        
        return get_instance()->app;
        
    }
    
}
