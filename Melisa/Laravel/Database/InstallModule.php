<?php namespace Melisa\Laravel\Database;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait InstallModule
{
    
    public function installModule(array $config) {
        
        return app('App\Core\Logics\Modules\Install')->init($config);
        
    }    
    
}
