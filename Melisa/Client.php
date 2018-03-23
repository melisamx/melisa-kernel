<?php

namespace Melisa;

use GuzzleHttp\Client as GuzzClient;
use GuzzleHttp\Exception\RequestException;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class Client
{
        
    protected $config;

    public function __construct($baseUri, $token)
    {
        $this->config = [
            'token'=>$token,
            'base_uri'=>$baseUri
        ];
    }
    
    public function setBaseUri($uri)
    {
        $this->config ['base_uri']= $uri;
        return $this;
    }
    
    public function createClientHttp()
    {
        return new GuzzClient([
            'base_uri'=>$this->config['base_uri']
        ]);
    }
    
    public function execute($method, $path, $headers = [], $params = null)
    {
        $client = $this->createClientHttp();
        
        $data = [
            'headers'=>[
                'Authorization'=>'Bearer ' . $this->config['token']
            ]
        ];
        
        if (!empty($headers)) {
            $data ['headers']= array_merge($data['headers'], $headers);
        }
        
        if ($method === 'GET') {
            $data ['query']= $params;
        } else if($method === 'POST') {
            $data ['json'] = $params;
        }
        
        try {
            $response = $client->request($method, $path, $data);
        } catch (RequestException $ex) {
            $response = $ex->getMessage();
        }
        
        if( is_string($response)) {
            return false;
        }
        
        return json_decode($response->getBody()->getContents());
    }
    
}
