<?php namespace Melisa\Laravel\Providers;

use Waavi\Sanitizer\Laravel\SanitizerServiceProvider as VendorSanitizer;
use Waavi\Sanitizer\Laravel\Factory;

class SanitizerServiceProvider extends VendorSanitizer
{
    
    protected $defer = true;
    
    /**
     * remove generate command
     */
    public function register()
    {
        
        
        $this->app->singleton('sanitize', function ($app) {
            return new Factory;
        });
        
    }
    
    public function provides()
    {
        
        return [
            Factory::class
        ];
        
    }
    
}
