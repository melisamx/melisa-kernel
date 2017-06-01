<?php

namespace Melisa\Laravel\Database;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait UpdateOrCreate
{
    
    public function updateOrCreate($clasName, array $records)
    {        
        $model = app()->make($clasName);
        
        if( !isset($records[0])) {            
            $records = [ $records ];            
        }
        
        foreach($records as $r) {
            
            if( isset($r['find'], $r['values'])) {                                
                $model::updateOrCreate($r['find'], $r['values']);                
            } else {                
                $model::updateOrCreate($r);                
            }
            
        }
        
    }
    
}
