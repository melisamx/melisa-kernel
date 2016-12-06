<?php namespace Melisa\Laravel\Database;

use Melisa\Laravel\Database\UpdateOrCreate;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait InstallOption
{
    use UpdateOrCreate;
    
    public function installOption($find, $values) {
        
        return $this->UpdateOrCreate('App\Core\Models\Options', [
            'find'=>$find
        ], [
            'values'=>$values
        ]);
        
    }    
    
}
