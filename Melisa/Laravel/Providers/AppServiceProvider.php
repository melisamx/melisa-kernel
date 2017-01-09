<?php namespace Melisa\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use App\Security\Logics\GatesSecurity;
use App\Core\Logics\Identities\Identities;
use App\Security\Logics\SystemSecurity\UserGod;

class AppServiceProvider extends ServiceProvider
{
        
    public function boot()
    {
        
        $this->app->singleton('identity', function ($app) {
            
            return $app->make(Identities::class);
            
        });
        
        $this->app->singleton('security', function ($app) {
            
            return $app->make(GatesSecurity::class);
            
        });
        
        $this->app->singleton('usergod', function ($app) {
            
            return $app->make(UserGod::class);
            
        });

    }
    
}
