<?php namespace Melisa\Laravel\Database;

use App\Core\Models\User;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait InstallUser
{
    
    public function installUser($name, $password, $values) {
        
        $values ['password']= bcrypt($password);
        
        return User::updateOrCreate([
            'name'=>$name
        ], $values);
        
    }
    
}
