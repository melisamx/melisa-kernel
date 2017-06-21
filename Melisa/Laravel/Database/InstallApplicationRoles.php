<?php

namespace Melisa\Laravel\Database;

use App\Core\Models\ApplicationsRoles;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait InstallApplicationRoles
{
    
    public function findApplicationRol($idApplication, $rolName)
    {        
        return ApplicationsRoles::where([
            'idApplication'=>$idApplication,
            'role'=>$rolName,
        ])->firstOrFail();        
    }
    
}
