<?php namespace Melisa\Laravel\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    
    public function map()
    {
        
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->mapCoreRoutes();
        
    }
    
    public function mapCoreRoutes() {
        
        Route::group([
            'middleware'=>'web',
            'namespace'=>'App\Core\Http\Controllers',
        ], function () {
            
            require realpath(base_path() . '/../Core/routes/core.php');
            
        });
        
    }
    
    public function mapWebRoutes()
    {
        
        Route::group([
            'middleware' => 'web',
            'namespace' => $this->namespace,
        ], function () {
            
            require base_path('routes/web.php');
        });
        
    }
    
    public function mapApiRoutes()
    {
        
        Route::group([
            'middleware' => 'api',
            'namespace' => $this->namespace . '\Api',
            'prefix' => 'api',
        ], function () {
            require base_path('routes/api.php');
        });
        
    }
    
}
