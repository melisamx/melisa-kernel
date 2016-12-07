<?php namespace Melisa\Laravel\Database;

use Melisa\Laravel\Database\UpdateOrCreate;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait InstallApplication
{
    use UpdateOrCreate;
    
    public function installApplication($find, $values) {
        
        return $this->UpdateOrCreate('App\Core\Models\Applications', [
            'find'=>[
                'key'=>$find
            ],
            'values'=>$values
        ]);
        
    }    
    
}
