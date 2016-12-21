<?php namespace Melisa\Laravel\Database;

use App\Core\Models\ApplicationsRS;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait InstallApplicationRS
{
    
    public function installRolScope($appKey, $rol, $scopeName, array $values) {
        
        $application = $this->findApplication($appKey);
        $applicationRol = $this->findApplicationRol($application->id, $rol);
        $identity = $this->findIdentity();
        $scope = $this->findScope($scopeName);
        
        $values ['idIdentityCreated']= $identity->id;
        
        return ApplicationsRS::updateOrCreate([
            'idApplicationRol'=>$applicationRol->id,
            'idScope'=>$scope->id
        ], $values);
        
    }
    
    public function findApplicationRolScope($idApplicationRol, $idScope) {
        
        return ApplicationsRS::where([
            'idApplicationRol'=>$idApplicationRol,
            'idScope'=>$idScope
        ])->firstOrFail();
        
    }
    
}
