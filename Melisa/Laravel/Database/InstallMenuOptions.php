<?php namespace Melisa\Laravel\Database;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait InstallMenuOptions
{
    
    public function installMenuOptions(array $config) {
        
        return app('App\Core\Logics\Menus\Install')->init($config);
        
    }    
    
}
