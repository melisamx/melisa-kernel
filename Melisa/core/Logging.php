<?php

namespace Melisa\core;
use Psr\Log\LoggerInterface as PsrLoggerInterface;
use Psr\Log\LogLevel as PsrLogLevel;

class Logging extends PsrLogLevel implements PsrLoggerInterface
{
    
    /**
     * Log an emergency message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return void
     */
    public function emergency($message, array $context = [])
    {
        
        return $this->writeLog(self::EMERGENCY, $message, $context);
        
    }
    
    /**
     * Log an alert message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return void
     */
    public function alert($message, array $context = [])
    {
        
        return $this->writeLog(self::ALERT, $message, $context);
        
    }
    
    /**
     * Log a critical message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return void
     */
    public function critical($message, array $context = [])
    {
        
        return $this->writeLog(self::CRITICAL, $message, $context);
        
    }
    
    /**
     * Log an error message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return void
     */
    public function error($message, array $context = [])
    {
        
        $this->writeLog(self::ERROR, $message, $context);
        return FALSE;
    }
    
    /**
     * Log a warning message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return void
     */
    public function warning($message, array $context = [])
    {
        return $this->writeLog(self::WARNING, $message, $context);
    }

    /**
     * Log a notice to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return void
     */
    public function notice($message, array $context = [])
    {
        return $this->writeLog(self::NOTICE, $message, $context);
    }
    
    /**
     * Log an informational message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return void
     */
    public function info($message, array $context = [])
    {
        return $this->writeLog(self::INFO, $message, $context);
    }
    
    /**
     * Log a debug message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return void
     */
    public function debug($message, array $context = [])
    {
        return $this->writeLog(self::DEBUG, $message, $context);
    }
    
    /**
     * Log a message to the logs.
     *
     * @param  string  $level
     * @param  string  $message
     * @param  array  $context
     * @return void
     */
    public function log($level, $message, array $context = []) {
        
        return $this->writeLog($level, $message, $context);
        
    }
    
    protected function writeLog($level, &$message, array &$context) {
        
        $data = melisa('array')->interpolate($message, $context);
        
        logger()->{$level}($data);
        
        melisa('msg')->add([
            'type'=>$level,
            'message'=>$data
        ]);
        
    }
    
}
