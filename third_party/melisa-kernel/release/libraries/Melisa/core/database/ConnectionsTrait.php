<?php

namespace Melisa\core\database;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait ConnectionsTrait
{    
    
    public function getConnectionManager(ConnectionManager $connectionManager = NULL) {
        
        static $cnxManager = NULL;
        
        if( $cnxManager) {
            
            return $cnxManager;
            
        }
        
        if( is_null($connectionManager)) {
            
            $cnxManager = $this->getApp()->load()
                ->libraries(__NAMESPACE__ . '\ConnectionManager');
            
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
    
    public function transactionAction($action, $group = NULL) {
        
        $connection = $this->loadConnection($this->getGroupConnetion($group));
        
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
    
    public function commit($group = NULL) {
        
        return $this->transactionCommit($group);
        
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
    
}
