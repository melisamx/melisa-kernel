<?php namespace Melisa\Laravel\Database;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait FirstOrCreate
{
    
    public function firstOrCreate($clasName, array $records) {
        
        $model = app()->make($clasName);
        
        foreach($records as $r) {
            
            $model::firstOrCreate($r);
            
        }
        
    }
    
}
