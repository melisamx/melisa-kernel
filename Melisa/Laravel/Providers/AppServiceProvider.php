<?php

namespace Melisa\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Melisa\codeigniter\CI_Security;
use App\Security\Logics\GatesSecurity;
use App\Core\Logics\Identities\Identities;
use App\Security\Logics\SystemSecurity\UserGod;
use App\Security\Logics\SystemSecurity\Art;
use App\Security\Logics\SystemSecurity\RbacLogic;
use Waavi\Sanitizer\Laravel\Factory;
use Melisa\Laravel\Services\UuidServices;
use Melisa\Laravel\Database\MySqlConnection;
use Illuminate\Database\Connection;
use Melisa\core\Messages;
use Melisa\Laravel\Providers\MessagesProvider;

/**
 * 
 * @author Luis Josafat Heredia Contreras
 */
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
        
        $this->app->singleton('rbac', function ($app) {            
            return $app->make(RbacLogic::class);            
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
        
        $this->app->singleton('messages', function() {
            return new MessagesProvider();
        });
    }
    
    public function register()
    {
        /* https://github.com/shiftonelabs/laravel-nomad */
        $class = MySqlConnection::class;
        $this->app->bind('db.connection.mysql', $class);        
        Connection::resolverFor('mysql', function ($connection, $database, $prefix, $config) use ($class) {
            return new $class($connection, $database, $prefix, $config);
        });
    }
    
}
