<?php namespace Melisa\Laravel\Database;

use Melisa\Laravel\Database\IdSeeder;

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
    
    public function installIdentity($profile = 'system', $username = 'developer', array $values = []) {
        
        $prodile = Profiles::where('key', $profile)->firstOrFail();
        $user = User::where('name', $username)->firstOrFail();
        
        Identities::updateOrCreate([
            'id'=>$this->getId(),
            'idProfile'=>$prodile->id,
        ], $values);
        
        UsersIdentities::firstOrCreate([
            'idUser'=>$user->id,
            'idIdentity'=>$this->getId()
        ]);
        
    }
    
    public function findIdentity($displayEspecific) {
        
        return Identities::where('displayEspecific', $displayEspecific)->firstOrFail();
        
    }
    
}
