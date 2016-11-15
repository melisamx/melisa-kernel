<?php namespace Melisa\Laravel\Database;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait IdSeeder
{
    
    public function getId() {
        
        static $id;
        
        if( !$id) {
            
            $id = env('ID_BASE', '83b78de3-ab6c-11e6-9095-080027f62005');
            
        }
        
        return $id;
        
    }
    
    public function getIdInt() {
        
        static $id;
        
        if( !$id) {
            
            $id = env('ID_BASE_INT', 1);
            
        }
        
        return $id;
        
    }
    
}
