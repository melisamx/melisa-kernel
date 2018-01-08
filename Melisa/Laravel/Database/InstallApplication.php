<?php

namespace Melisa\Laravel\Database;

use App\Core\Models\Applications;
use App\Core\Models\ApplicationsVersions;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait InstallApplication
{
    
    public function installApplication($find, $values)
    {
        $comments = isset($values['comments']) ? $values['comments'] : null;
        if( !is_null($comments)) {
            unset($values['comments']);
        }
        
        $application = Applications::updateOrCreate([
            'key'=>$find,
        ], $values);        
        
        if( $comments) {
            ApplicationsVersions::updateOrCreate([
                'idApplication'=>$application->id,
                'version'=>$values['version']
            ], [
                'comments'=>$comments
            ]);
        }
        
        return $application;
    }
    
    public function findApplication($key)
    {        
        return Applications::where('key', $key)->first();        
    }
    
}
