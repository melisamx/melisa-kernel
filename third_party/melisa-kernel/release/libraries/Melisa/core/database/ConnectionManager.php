<?php 

namespace Melisa\core\database;
use Melisa\core\Base;
use Melisa\contracts\database\ConnectionManagerInterface;

/**
 * Manages connections to database
 * @version 1.0
 * @author Luis Josafat Heredia Contreras
 */
class ConnectionManager extends Base implements ConnectionManagerInterface
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
        
        /* verificamos si el grupo lo habiamos cargado */
        if( isset($connections[$group])) {
            
            /* las conexiones mysqli crean un objeto no una cadena identificadora */
            $conexionId = $connections[$group]->dbdriver === 'mysqli' ? 
                    $connections[$group]->username . $connections[$group]->database : 
                    $connections[$group]->conn_id;
            
            logger()->debug('Reuse connection {g} with identifier {i}', [
                'g'=>$group,
                'i'=>$conexionId
            ]);
        
            return $connections[$group];
            
        }
        
        if( empty($config)) {
            
            /* creamos la conexion basada en grupo */
            $connections[$group] = $this->create($group);
            
        } else {
            
            /* creamos la conexion basada en configuración dinamica */
            $connections[$group] = $this->create($group, $config);
            
        }
        
        /* las conexiones mysqli crean un objeto no una cadena identificadora */
        $conexionId = $connections[$group]->dbdriver === 'mysqli' ? 
                $connections[$group]->username . $connections[$group]->database : 
                $connections[$group]->conn_id;
        
        logger()->debug('Use connection {g} con identificador {i}', [
            'g'=>$group,
            'i'=>$conexionId
        ]);
        
        if( !$connections[$group]->conn_id) {
            
            return $conexionId;
            
        }
        
        /* se agrego para poder usar nerine forge y obtener el nombre del grupo */
        $connections[$group]->grupoName = $group;
        
        return $connections[$group];        
        
    }
    
    public function create($group, $config = []) {
        
        logger()->debug('Connection {g} create', [
            'g'=>$group
        ]);
        
        if( !empty($config)) {
            
            return get_instance()->abs->load_database($config, TRUE);
            
        }
        
        return get_instance()->abs->load_database($group, TRUE);
        
    }
    
    public function loadUtil($group, $config = []) {
        
        static $conexionUtil = array();
        
        /* verificamos si el grupo lo habiamos cargado */
        if( isset($conexionUtil[$group])) {
            
            return $conexionUtil[$group];
            
        }
        
        $conexion = $this->load($group, $config);
        
        if( $conexion === FALSE) {
            
            return FALSE;
            
        }
        
        return $conexionUtil[$group] = get_instance()->load->dbutil($conexion, TRUE);
        
    }
    
}
