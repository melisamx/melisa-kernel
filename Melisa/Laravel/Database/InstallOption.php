<?php namespace Melisa\Laravel\Database;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait InstallOption
{
    
    public function installOption($find, $values) {
        
        return $this->updateOrCreate('App\Core\Models\Options', [
            'find'=>[
                'key'=>$find
            ],
            'values'=>$values
        ]);
        
    }    
    
}
