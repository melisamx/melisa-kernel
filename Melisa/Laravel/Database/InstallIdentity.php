<?php namespace Melisa\Laravel\Database;

use App\Core\Models\Identities;
use App\Core\Models\UsersIdentities;
use App\Core\Models\Profiles;
use App\Core\Models\User;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait InstallIdentity
{
    
    public function installIdentity($displayEspecific, $profileKey = 'system', $username = 'developer', array $values = []) {
        
        $profile = Profiles::where('key', $profileKey)->firstOrFail();
        $user = User::where('name', $username)->firstOrFail();
        
        Identities::updateOrCreate([
            'displayEspecific'=>$displayEspecific,
            'idProfile'=>$profile->id,
        ], $values);
        
        $identity = $this->findIdentity($displayEspecific);
        
        UsersIdentities::updateOrCreate([
            'idUser'=>$user->id,
            'idIdentity'=>$identity->id
        ]);
        
    }
    
    public function findIdentity($displayEspecific = 'Developer') {
        
        return Identities::where('displayEspecific', $displayEspecific)->firstOrFail();
        
    }
    
}
