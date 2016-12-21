<?php namespace Melisa\Laravel\Database;

use App\Core\Models\ApplicationsRST;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait InstallApplicationRST
{
    
    public function installRolScopeTask($appKey, $rol, $scopeName, $taskKey, array $values = []) {
        
        $application = $this->findApplication($appKey);
        $applicationRol = $this->findApplicationRol($application->id, $rol);
        $scope = $this->findScope($scopeName);
        $identity = $this->findIdentity();
        $applicationRS = $this->findApplicationRolScope($applicationRol->id, $scope->id);
        $task = $this->findTask($taskKey);
        
        $values ['idIdentityCreated']= $identity->id;
        
        return ApplicationsRST::updateOrCreate([
            'idApplicationRS'=>$applicationRS->id,
            'idTask'=>$task->id
        ], $values);
        
    }
    
}
