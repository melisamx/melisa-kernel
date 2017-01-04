<?php namespace Melisa\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use App\Security\Logics\Security\Security;
use App\Core\Logics\Identities\Identities;

class AppServiceProvider extends ServiceProvider
{
        
    public function boot()
    {
        
        $this->app->singleton('identity', function ($app) {
            
            return $app->make(Identities::class);
            
        });
        
        $this->app->singleton('security', function ($app) {
            
            return $app->make(Security::class);
            
        });

    }
    
}
