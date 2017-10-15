<?php

namespace Melisa\core;

use Melisa\core\Event;
use Melisa\Repositories\Contracts\RepositoryInterface;

trait LogicBusiness
{
    
    public $acts = [];
    
    public function getIdentity()
    {        
        return app('identity')->get();        
    }
    
    public function isAllowed($gate = '*')
    {        
        return app('security')->isAllowed($gate);        
    }
    
    public function error($message, array $data = [])
    {        
        return melisa('logger')->error($message, $data);        
    }
    
    public function debug($message, array $data = [])
    {        
        return melisa('logger')->debug($message, $data);        
    }
    
    public function info($message, array $data = [])
    {        
        return melisa('logger')->info($message, $data);        
    }
    
    public function debugLastQuery($database = null)
    {        
        if( !$database) {
            $queries = \DB::getQueryLog();
        } else {
            $queries = \DB::connection($database)->getQueryLog();
        }        
        
        $lastQuery = end($queries);        
        return melisa('logger')->debug($lastQuery['query']);        
    }

    public function make($key)
    {        
        if( isset($this->acts[$key])) {            
            return $this->acts[$key];            
        }
        
        return $this->acts[$key] = app()->make($this->makes[$key]);        
    }
    
    public function emitEvent($key, $data = null)
    {        
        $result = event(new Event($key, $data));        
        if( in_array(false, $result)) {            
            return false;            
        }        
        return true;        
    }
    
    public function fireEvent(array &$event)
    {
        if( !$this->emitEvent($this->eventSuccess, $event)) {
            return false;
        }        
        return true;
    }
    
    public function updateRepository(
        RepositoryInterface &$repository,
        array &$input, 
        $messageError = 'Imposible modificar registro',
        $rollback = true
    )
    {
        $result = $repository->update($input, $input['id']);
        
        if( $result !== false) {
            return true;
        }
        
        $this->error($messageError);
        
        if( !$rollback) {
            return false;
        }
        
        return $repository->rollback();
    }
    
    public function inyectIdentity(&$input)
    {
        if( !isset($input ['idIdentityCreated'])) {
            $input ['idIdentityCreated']= $this->getIdentity();
        }
    }
    
}
