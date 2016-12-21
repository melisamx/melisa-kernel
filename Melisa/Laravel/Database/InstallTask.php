<?php namespace Melisa\Laravel\Database;

use App\Core\Models\Tasks;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait InstallTask
{
    
    public function installTask($key, array $values = []) {
        
        return Tasks::updateOrCreate([
            'key'=>$key
        ], $values);
        
    }
    
    public function findTask($key) {
        
        return Tasks::where('key', $key)->firstOrFail();
        
    }
    
}
