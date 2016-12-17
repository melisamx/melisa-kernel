<?php namespace Melisa\Laravel\Database;

use App\Core\Models\Applications;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait InstallApplication
{
    
    public function installApplication($find, $values) {
        
        return $this->updateOrCreate('App\Core\Models\Applications', [
            'find'=>[
                'key'=>$find
            ],
            'values'=>$values
        ]);
        
    }
    
    public function findApplication($key) {
        
        return Applications::where('key', $key)->firstOrFail();
        
    }
    
}
