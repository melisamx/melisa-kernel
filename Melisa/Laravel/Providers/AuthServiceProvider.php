<?php

namespace Melisa\Laravel\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * 
 * @author Luis Josafat Heredia Contreras
 */
class AuthServiceProvider extends ServiceProvider
{
    
    protected $policies = [];

    public function boot()
    {
        $this->registerPolicies();
        
    }
    
}
