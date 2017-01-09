<?php

namespace Melisa\core\database;

use Melisa\contracts\database\ConnectionManagerInterface;
use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class IlluminateConnectionManager implements ConnectionManagerInterface
{
    
    public function &load($group, array $config = []) {
        
        static $connections = [];
        
        /* verificamos si requiere cargara varias conexiones */
        if( is_array($group)) {
            
            /* bandera para saber si en alguna carga tubo algun error */
            $retornar = TRUE;
            
            /* recorremos el array de modelos a cargar */
            foreach($group as $nameGroup) {
                
                /* ejecutamos recursivamente la carga del modelo */
                if( !$this->load($nameGroup)) {
                    
                    $retornar = FALSE;
                    break;
                    
                }
                
            }
            
            return $retornar;
            
        }
        
        if( isset($connections[$group])) {
            
            exit(var_dump('reuse connection'));
            return $connections[$group];
            
        }
        
        if( empty($config)) {
            
            /* creamos la conexion basada en grupo */
            $connections[$group] = $this->create($group);
            
        } else {
            
            /* creamos la conexion basada en configuración dinamica */
            $connections[$group] = $this->create($group, $config);
            
        }
        
    }
    
    public function create($group, $config = []) {
        
        logger()->debug('{c} Connection {g} create', [
            'c'=>__CLASS__,
            'g'=>$group
        ]);
        
        if( !empty($config)) {
            
            
        }
        
        
    }
    
    public function loadUtil($group, $config = []) {
        
        
    }
    
    public function createCapsule() {
        
        static $capsule = NULL;
        
        if( $capsule) {
            
            return $capsule;
            
        }
        
        $capsule = new Capsule;
        
        get_instance()->abs->get;
        
        return $capsule;
        
    }
    
}
