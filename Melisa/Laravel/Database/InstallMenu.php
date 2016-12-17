<?php namespace Melisa\Laravel\Database;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait InstallMenu
{
    
    public function installMenu($find, array $values) {
        
        return $this->updateOrCreate('App\Core\Models\Menus', [
            'find'=>[
                'key'=>$find
            ],
            'values'=>$values
        ]);
        
    }
    
}
