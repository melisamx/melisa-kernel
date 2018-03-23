<?php

namespace Melisa;

use Melisa\Client;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class Service
{
    
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    
    public function getClient()
    {
        return $this->client;
    }
    
}
