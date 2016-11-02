<?php 

namespace Melisa\core\database;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait GroupDatabaseTrait
{
    
    public function getGroupConnetion($group = NULL) {
        
        if( $group) {
            
            return $group;
            
        }
        
        $app = $this->getApp();
        
        return isset($app->db_app) ? $app->db_app : $app->db;
        
    }
    
}
