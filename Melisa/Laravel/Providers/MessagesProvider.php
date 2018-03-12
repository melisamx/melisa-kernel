<?php

namespace Melisa\Laravel\Providers;

use Illuminate\Support\Collection;

class MessagesProvider
{
    
    protected $collection;

    public function __construct($collection = null) {
        if( is_null($collection)) {
            $this->collection = new Collection([]);
        }
    }
    
    public function debug($message, array $context = [])
    {
        $data = melisa('array')->interpolate($message, $context);
        logger()->debug($data);
        $this->add([
            'type'=>'debug',
            'message'=>$data,
        ]);
    }
    
    public function info($message, array $context = [])
    {
        $data = melisa('array')->interpolate($message, $context);
        logger()->info($data);
        $this->add([
            'type'=>'info',
            'message'=>$data,
        ]);
    }
    
    public function errorCode($code, array $context = [])
    {
        $message = $this->getMessageCode($code, $context);
        $this->add([
            'message'=>$message,
            'code'=>$code
        ]);
    }
    
    public function getMessageCode($code, $data = [])
    {
        static $errors = null;        
        if( !$errors) {
            $errors = config('errors');
        }
        
        $message = isset($errors[$code]) ? $errors[$code] : null;
        
        if( !empty($data) && !is_null($message)) {
            $message = melisa('array')->interpolate($message, $data);
        }
        
        return $message;
    }
    
    public function error($message, array $context = [])
    {
        $data = melisa('array')->interpolate($message, $context);
        logger()->error($data);
        $this->add([
            'message'=>$data,
        ]);
    }

    public function add($input)
    {
        $message = melisa('array')->mergeDefault($input, [
            'type'=>'error',
            'message'=>'',
            'code'=>''
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
            return collect($record)->only('code', 'message')->toArray();
        })->values()->toArray();
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
