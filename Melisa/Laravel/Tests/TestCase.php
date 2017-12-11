<?php

namespace Melisa\Laravel\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Contracts\Console\Kernel;

abstract class TestCase extends BaseTestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = '';
    protected $bootstrapFile;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        
        $app = require __DIR__. "/../../../bootstrap/$this->bootstrapFile.php";
        $app->make(Kernel::class)->bootstrap();
        return $app;        
    }
    
    public function runPostBadInput(array $casesInput)
    {
        foreach($casesInput as $input) {
            $response = $this->actingAs($this->user)
                ->json('post', $this->endpoint, $input);
            $this->responseWithErrors($response, 422);
        }  
    }
    
}
