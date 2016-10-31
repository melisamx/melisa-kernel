<?php

namespace Melisa\core;
use Melisa\contracts\database\ConnectionManagerInterface as ConnectionManager;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class Database extends Base
{
    
    public function getConnectionManager(ConnectionManager $connectionManager = NULL) {
        
        static $cnxManager = NULL;
        
        if( $cnxManager) {
            
            return $cnxManager;
            
        }
        
        if( is_null($connectionManager)) {
            
            $cnxManager = get_instance()
                ->app
                ->load()
                ->libraries(__NAMESPACE__ . '\\database\\ConnectionManager');
            
        } else {
            
            $cnxManager = $connectionManager;
            
        }
        
        return $cnxManager;
        
    }
    
    public function transactionInit($group = NULL) {
        
        return $this->transactionAction('trans_begin', $group);
        
    }
    
    public function transactionCommit($group = NULL) {
        
        return $this->transactionAction('trans_commit', $group);
        
    }
    
    public function transactionRollback($group = NULL) {
        
        return $this->transactionAction('trans_rollback', $group);
        
    }
    
    private function transactionAction($action, $group = NULL) {
        
        $connection = $this->loadConnection($this->getGroupConnexion($group));
        
        if( $connection) {
            
            $this->log()->debug('{c} {a} runner', [
                'c'=>__CLASS__,
                'a'=>$action
            ]);
            
            return $connection->{$action}();
            
        }
        
        return FALSE;
        
    }
    
    public function transactionStatus($group = NULL) {
        
        return $this->transactionAction('trans_status', $group);
        
    }
    
    public function rollback($message, array $context = [], $group = NULL) {
        
        $this->transactionRollback($group);
        
        $this->log()->error($message, $context);
        
        return FALSE;
        
    }
    
    public function runModel(array $config = [], array &$input = [], array &$params = []) {
        
        if( !$this->isValid($config)) {
            
            return FALSE;
            
        }
        
        $connection = $this->loadConnection($config['conexion']);
        
        if( !$connection) {
            
            return FALSE;
            
        }
        
        if( !$this->isValidModel($config)) {
            
            return FALSE;
            
        }
        
        return $this->run($connection, $config, $input, $params);
        
    }
    
    public function run(&$cnx, &$config, &$input, &$params) {
        
        $ci = &get_instance();
        
        if(is_null($input)) {
            
            $result = $ci->{$config['model']}->{$config['function']}($cnx, $params);
            
        } else {
            
            $result = $ci->{$config['model']}->{$config['function']}($cnx, $input, $params);
            
        }
        
        if( $result !== FALSE) {
            
            $this->log()->debug('{c}. Last query success: {q}', [
                'c'=>__CLASS__,
                'q'=>$cnx->last_query()
            ]);
            
            return $result;
            
        }
        
        return $result;
        
    }
    
    public function loadConnection($group) {
        
        $connection = $this->getConnectionManager()
            ->load($group);
        
        if( $connection === FALSE) {
            
            return $this->log()->error('{a}. Unable to connect to database server using the settings provided in the group {g}', [
                'c'=>__CLASS__,
                'g'=>$group
            ]);
            
        }
        
        return $connection;
        
    }
    
    public function isValidModel(&$config) {
        
        $this->log()->debug('{c}. Is valid model {p}{m} ?', [
            'c'=>__CLASS__,
            'p'=>$config['path'],
            'm'=>$config['model']
        ]);
        
        $ci = &get_instance();
        $ci->abs->load_model($config['path'] . $config['model']);
        
        if( !method_exists($ci->{$config['model']}, $config['function'])) {
            
            return $this->log()->error('{c}. No exist function {f} in the model {m}', [
                'c'=>__CLASS__,
                'f'=>$config['function'],
                'm'=>$config['path'] . $config['model'],
            ]);
            
        }
        
        return TRUE;
        
    }
    
    public function getGroupConnexion($group = NULL) {
        
        if( $group) {
            
            return $group;
            
        }
        
        $app = get_instance()->app;
        
        return isset($app->db_app) ? $app->db_app : $app->db;
        
    }

    public function isValid(&$config = []) {
        
        $config = array_default($config, [
            'path'=>'',
            'function'=>'init',
            'conexion'=>$this->getGroupConnexion()
        ]);
        
        if( isset($config['conexion'], $config['model'], $config['function'])) {
            
            return TRUE;
            
        }
        
        return $this->log()->error('Required parameters not received: {r}', [
            'r'=>print_r($config, TRUE)
        ]);
        
    }
    
}
