<?php namespace Melisa\Laravel\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    
    protected $policies = [];

    public function boot()
    {
        $this->registerPolicies();
        
    }
    
}
