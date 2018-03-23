<?php

namespace Melisa\Services;

use Melisa\Service;
use Melisa\Client;
use Melisa\Services\Cms\Spaces;
use Melisa\Services\Cms\Content;
use Melisa\Services\Cms\ContentTypes;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class Cms extends Service
{
    
    protected $client;
    public $spaces;

    public function __construct(Client $client)
    {
        parent::__construct($client);
        $this->spaces = new Spaces($this);
        $this->content = new Content($this);
        $this->contentTypes = new ContentTypes($this);
    }
    
}
