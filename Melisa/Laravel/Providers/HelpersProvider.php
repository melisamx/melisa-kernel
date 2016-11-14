<?php namespace Melisa\Laravel\Providers;

use Illuminate\Support\ServiceProvider;

class HelpersProvider extends ServiceProvider
{

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        
        require_once realpath(base_path() . '/../../Melisa/Laravel/helpers.php');
        
    }
    
}
