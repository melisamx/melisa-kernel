<?php

namespace Melisa\Laravel\Database;

use App\Core\Models\Redirects;
use App\Core\Models\RedirectsProfiles;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait InstallRedirect
{
    
    public function installRedirect($appKey, $name, array $values)
    {        
        $application = $this->findApplication($appKey);
        $identity = $this->findIdentity('developer');
        $values ['idIdentityCreated']= $identity->id;
        
        return Redirects::updateOrCreate([
            'idApplication'=>$application->id,
            'name'=>$name,
        ], $values);        
    }
    
    public function installRedirectProfile($redirectName, $profileKey, array $values = [])
    {        
        $redirect = $this->findRedirect($redirectName);
        $identity = $this->findIdentity('developer');
        $profile = $this->findProfile($profileKey);
        
        $values ['idIdentityCreated']= $identity->id;
        $values ['active']= isset($values['active']) ? $values['active'] : true;
        
        return RedirectsProfiles::updateOrCreate([
            'idRedirect'=>$redirect->id,
            'idProfile'=>$profile->id,
        ], $values);        
    }
    
    public function findRedirect($name)
    {        
        return Redirects::where('name', $name)->firstOrFail();        
    }
    
}
