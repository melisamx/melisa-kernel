<?php namespace Melisa\Laravel\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    
    public function map()
    {
        
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        
    }
    
    public function mapWebRoutes()
    {
        
        Route::group([
            'middleware' => 'web',
            'namespace' => $this->namespace,
        ], function ($router) {
            
            require base_path('routes/web.php');
        });
        
    }
    
    public function mapApiRoutes()
    {
        
        Route::group([
            'middleware' => 'api',
            'namespace' => $this->namespace,
            'prefix' => 'api',
        ], function ($router) {
            require base_path('routes/api.php');
        });
        
    }
    
}
