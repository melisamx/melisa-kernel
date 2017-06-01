<?php

namespace Melisa\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Melisa\libraries\Uuid;

/**
 * 
 * @author Luis Josafat Heredia Contreras
 */
class UuidProvider extends ServiceProvider
{
    
    protected $defer = true;
    
    public function register()
    {        
        $this->app->singleton(Uuid::class, function() {
            return new Uuid();
        });        
    }
    
    public function provides()
    {
        return [Uuid::class];
    }
    
}
