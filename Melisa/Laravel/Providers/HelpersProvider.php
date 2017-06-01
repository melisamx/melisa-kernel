<?php

namespace Melisa\Laravel\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * 
 * @author Luis Josafat Heredia Contreras
 */
class HelpersProvider extends ServiceProvider
{
    
    public function register()
    {        
        require_once realpath(base_path() . '/../../Melisa/Laravel/helpers.php');        
    }
    
}
