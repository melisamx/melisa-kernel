<?php namespace Melisa\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Melisa\codeigniter\CI_Security;
use App\Security\Logics\GatesSecurity;
use App\Core\Logics\Identities\Identities;
use App\Security\Logics\SystemSecurity\UserGod;
use App\Security\Logics\SystemSecurity\Art;
use Waavi\Sanitizer\Laravel\Factory;
use Melisa\Laravel\Services\UuidServices;

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
        
        $this->app->singleton('art', function ($app) {
            
            return $app->make(Art::class);
            
        });
        
        $this->app->singleton('xss', function ($app) {
            
            return $app->make(CI_Security::class);
            
        });
        
        $this->app->singleton('sanitize', function ($app) {
            return new Factory;
        });
        
        $this->app->singleton('uuid', function ($app) {
            return new UuidServices();
        });

    }
    
}
