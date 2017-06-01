<?php

namespace Melisa\Laravel\Database;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait InstallEvent
{
    
    public function installEvent($find, array $values)
    {        
        $model = app()->make('App\Core\Models\Events');
        
        return $model::updateOrCreate([
            'key'=>$find
        ], $values);        
    }
    
}
