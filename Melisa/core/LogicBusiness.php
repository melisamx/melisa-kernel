<?php namespace Melisa\core;

use Melisa\core\Event;

trait LogicBusiness
{
    
    public $acts = [];
    
    public function error($message, array $data = []) {
        
        return melisa('logger')->error($message, $data);
        
    }
    
    public function debug($message, array $data = []) {
        
        return melisa('logger')->debug($message, $data);
        
    }
    
    public function info($message, array $data = []) {
        
        return melisa('logger')->info($message, $data);
        
    }
    
    public function debugLastQuery() {
                
        $queries = \DB::getQueryLog();
        $lastQuery = end($queries);
        
        return melisa('logger')->debug($lastQuery['query']);
        
    }

    public function make($key) {
        
        if( isset($this->acts[$key])) {
            
            return $this->acts[$key];
            
        }
        
        return $this->acts[$key] = app()->make($this->makes[$key]);
        
    }
    
    public function emitEvent($key, $data = null) {
        
        $result = event(new Event($key, $data));
        
        if( in_array(false, $result)) {
            
            return false;
            
        }
        
        return true;
        
    }
    
}
