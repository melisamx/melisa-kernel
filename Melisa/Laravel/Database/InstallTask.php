<?php

namespace Melisa\Laravel\Database;

use App\Core\Models\Tasks;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait InstallTask
{
    
    public function installTask($key, array $values = [])
    {        
        return Tasks::updateOrCreate([
            'key'=>$key
        ], $values);        
    }
    
    public function findTask($key)
    {        
        return Tasks::where('key', $key)->firstOrFail();        
    }
    
    public function findTasks($query)
    {        
        return Tasks::where('key', 'like', $query)->get();        
    }
    
    public function findTasksRead($query)
    {
        return Tasks::where('key', 'like', $query)
            ->where('pattern', 9)
            ->get();
    }
    
    public function getTasksKeys($query)
    {
        $tasks = $this->findTasks($query);        
        if( !$tasks->count()) {
            return [];
        }        
        return $tasks->pluck('key')->toArray();
    }
    
    public function getTasksKeysRead($query)
    {
        $tasks = $this->findTasksRead($query);
        if( !$tasks->count()) {
            return [];
        }        
        return $tasks->pluck('key')->toArray();
    }
    
}
