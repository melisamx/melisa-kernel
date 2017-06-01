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
    
    public function installApplicationRol($appKey, $rol, array $values)
    {        
        $application = $this->findApplication($appKey);
        $identity = $this->findIdentity();
        
        return ApplicationsRoles::updateOrCreate([
            'idApplication'=>$application->id,
            'idIdentityCreated'=>$identity->id,
            'role'=>$rol
        ], $values);        
    }
    
    public function findApplicationRol($idApplication, $rolName)
    {        
        return ApplicationsRoles::where([
            'idApplication'=>$idApplication,
            'role'=>$rolName,
        ])->firstOrFail();        
    }
    
}
