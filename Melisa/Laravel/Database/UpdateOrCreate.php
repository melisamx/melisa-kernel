<?php namespace Melisa\Laravel\Database;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait UpdateOrCreate
{
    
    public function UpdateOrCreate($clasName, array $records) {
        
        $model = app()->make($clasName);
        
        foreach($records as $r) {
            
            if( isset($r['find'], $r['values'])) {
                                
                $model::updateOrCreate($r['find'], $r['values']);
                
            } else {
                
                $model::updateOrCreate($r);
                
            }
            
        }
        
    }
    
}