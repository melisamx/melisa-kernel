<?php

namespace Melisa\core;

use Illuminate\Support\Collection;

class Messages
{
    
    protected $collection;


    public function __construct($collection = null) {
        if( is_null($collection)) {
            $this->collection = new Collection([]);
        }
    }

    public function add($input)
    {
        $message = melisa('array')->mergeDefault($input, [
            'type'=>'error',
            'message'=>''
        ]);
        
        $this->addMessage($message);        
    }
    
    public function get()
    {
        if( config('app.env') === 'local') {
            return $this->collection->all();
        }
        return $this->getErrors();
    }
    
    public function getErrors()
    {        
        return $this->collection->where('type', 'error')->map(function($record) {
            return collect($record)->only('message')->toArray();
        })->values();
    }
    
    public function getInfo()
    { 
        return $this->collection->where('type', 'info')->map(function($record) {
            return collect($record)->only('message')->toArray();
        })->values();
    }
    
    public function getDebug()
    { 
        return $this->collection->where('type', 'debug')->map(function($record) {
            return collect($record)->only('message')->toArray();
        })->values();
    }
    
    public function getAllTypes()
    {
        return [
            'errors'=>$this->getErrors(),
            'info'=>$this->getInfo(),
            'debug'=>$this->getDebug(),
        ];
    }
    
    private function addMessage($message)
    {        
        $this->collection->push($message);
        return $message;
    }
    
}
