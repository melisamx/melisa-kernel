<?php

namespace Melisa\Laravel\Database;

use App\Core\Models\Profiles;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait InstallProfile
{
    
    public function installProfile($find, $values)
    {        
        return Profiles::updateOrCreate([
            'key'=>$find
        ], $values);        
    }
    
    public function findProfile($key)
    {        
        return Profiles::where('key', $key)->firstOrFail();        
    }
    
}
