<?php namespace Melisa\Laravel\Database;

use App\Core\Models\Scopes;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait InstallScope
{
    
    public function installScope($id, $find, array $values = []) {
        
        return Scopes::updateOrCreate([
            'id'=>$id,
            'name'=>$find
        ], $values);
        
    }
    
    public function findScope($name) {
        
        return Scopes::where('name', $name)->firstOrFail();
        
    }
    
}
