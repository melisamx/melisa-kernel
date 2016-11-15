<?php namespace Melisa\Laravel\Database;

use Melisa\Laravel\Database\IdSeeder;

use App\Core\Models\Identities;
use App\Core\Models\UsersIdentities;
use App\Core\Models\People;
use App\Core\Models\Profiles;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait CreateIdentity
{
    use IdSeeder;
    
    public function createIdentity($profile = 'system') {
        
        $idProfile = Profiles::where('key', $profile)->firstOrFail();
        
        Identities::firstOrCreate([
            'id'=>$this->getId(),
            'idProfile'=>$idProfile->id,
            'display'=>'Developer',
            'displayEspecific'=>'Developer',
            'active'=>true,
            'isDefault'=>true,
        ]);
        
        UsersIdentities::firstOrCreate([
            'idUser'=>$this->getId(),
            'idIdentity'=>$this->getId()
        ]);
        
        People::firstOrCreate([
            'id'=>$this->getId(),
            'name'=>'Developer',
            'firstName'=>'in',
            'lastName'=>'house',
            'nickname'=>'Developer',
        ]);
        
    }
    
}
