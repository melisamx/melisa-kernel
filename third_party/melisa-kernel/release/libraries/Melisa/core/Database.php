<?php

namespace Melisa\core;
use \Melisa\core\database\GroupDatabaseTrait;
use \Melisa\core\database\ConnectionsTrait;

/**
 * 
 * 
 * @author Luis Josafat Heredia Contreras
 */
class Database extends Base
{
    use GroupDatabaseTrait, ConnectionsTrait;
    
    public function runModel(array $config = [], array &$input = [], array &$params = []) {
        
        if( !$this->isValid($config)) {
            
            return FALSE;
            
        }
        
        $connection = $this->loadConnection($config['connection']);
        
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
    
    public function isValidModel(&$config) {
        
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

    public function isValid(&$config = []) {
        
        $config = array_default($config, [
            'path'=>'',
            'function'=>'init',
            'connection'=>NULL
        ]);
        
        if( is_null($config['connection'])) {
            
            $config ['connection']= $this->getGroupConnetion();
            
        }
        
        if( isset($config['connection'], $config['model'], $config['function'])) {
            
            return TRUE;
            
        }
        
        return $this->log()->error('Required parameters not received: {r}', [
            'r'=>print_r($config, TRUE)
        ]);
        
    }
    
}
