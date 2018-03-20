<?php

namespace Melisa\Laravel\Database;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Core\Models\User;
use App\Security\Models\OAuthAccessTokens;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait RunApi
{
    
    protected $client;
    protected $headers = [];
    protected $token;

    public function getUserEmail()
    {
        return env('USER_EMAIL');
    }
    
    public function getUser()
    {
        return User::where('email', $this->getUserEmail())->first();
    }

    public function createClient(array $config)
    {
        return new Client($config);
    }
    
    public function isSuccess(&$response)
    {
        if( !$response) {
            return false;
        }
        
        if( !isset($response->success)) {
            return false;
        }
        
        return $response->success;
    }
    
    public function api($config)
    {
        if ( is_array($config)) {
            $this->client = $this->createClient($config);
        } else {
            $this->client = $this->createClient([
                'base_uri'=>env('APP_URL') . $config
            ]);
        }
        
        return $this;
    }
    
    public function createToken()
    {
        if ($this->token) {
            return $this->token;
        }
        
        $this->token = $this->getUser()->createToken('temporal');
        return $this->token;
    }
    
    public function cleanToken()
    {
        app(OAuthAccessTokens::class)->deleteById($this->token->token->id);
        $this->token = null;
        return $this;
    }
    
    public function withToken()
    {
        $token = $this->createToken();
        $this->headers ['Authorization']= 'Bearer ' . $token->accessToken;
        $this->headers ['Content-Type']= 'application/json';
        return $this;
    }
    
    public function post($endpoint, array $data = [])
    {
        $params = [
            'json'=>$data,
            'headers'=>$this->headers
        ];
        
        try {
            $response = $this->client->post($endpoint, $params);
        } catch (RequestException $ex) {
            $response = $ex->getMessage();
            return $response;
        }
        
        return json_decode($response->getBody()->getContents());
    }
    
}
