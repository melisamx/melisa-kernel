<?php

namespace Melisa;

use GuzzleHttp\Psr7\Request;
use Melisa\Exception;
use Melisa\Client;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class Resource
{
    
    protected $servicePath;
    protected $methods;
    protected $serviceName;
    protected $resourceName;
    
    public function __construct($service)
    {
        $this->client = $service->getClient();
    }
    
    public function call($name, $arguments)
    {
        if (! isset($this->methods[$name])) {
            throw new Exception("Unknown function: " . 
                "{$this->serviceName} - {$this->resourceName} - {$name}");
        }
        
        $method = $this->methods[$name];
        $parameters = isset($arguments[0]['parameters']) ? 
            $arguments[0]['parameters'] : [];
        $parametersUrl = isset($arguments[0]['parametersUrl']) ? 
            $arguments[0]['parametersUrl'] : [];
        $methodType = strtoupper($method['method']);
        
        if ( !empty($parametersUrl)) {
            $method ['path']= $this->interpolate($method['path'], $parametersUrl);
        }
        
        $result = $this->client->execute(
            $methodType,
            $method['path'],
            [
                'content-type'=>'application/json'
            ],
            $parameters
        );
        
        if ($result) {
            return $this->getResult($result);
        }
        
        return false;
    }
    
    public function getResult(&$result)
    {
        if (!$result->success) {
            return false;
        }
        return $result->data;
    }
    
    private function interpolate($template, array $context = [])
    {        
        /* build a replacement array with braces around the context keys */
        $keysReplace = [];
        foreach($context as $key => $val) {            
            // check that the value can be casted to string
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {                
                $keysReplace['{'.$key.'}'] = $val;                
            }            
        }
        
        /* interpolate replacement values into the message and return */
        return strtr($template, $keysReplace);        
    }
    
}
