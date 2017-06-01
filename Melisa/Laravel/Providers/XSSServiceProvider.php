<?php

namespace Melisa\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Melisa\codeigniter\CI_Security;

/**
 * Description of Xss
 *
 * @author Luis Josafat Heredia Contreras
 */
class XSSServiceProvider extends ServiceProvider
{
    
    public function boot()
    {        
        $this->app->singleton('xss', function ($app) {            
            return $app->make(CI_Security::class);            
        });
        
    }
    
}
