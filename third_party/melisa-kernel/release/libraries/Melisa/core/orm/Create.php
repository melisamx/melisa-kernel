<?php

namespace Melisa\core\orm;

use Melisa\core\database\GroupDatabaseTrait;
use Melisa\core\database\ConnectionsTrait;
use Melisa\core\orm\InputTrait;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class Create
{
    
    use InputTrait, GroupDatabaseTrait, ConnectionsTrait;
    
    public function init(array $config = []) {
        
        $config = $this->getConfig($config);
        
        $input = $this->getRequired($config);
        
        if( $input === FALSE) {
            
            return FALSE;
            
        }
        
        if( !$this->isValidInput($input, $config)) {
            
            return FALSE;
            
        }
        
        if( $config['transaction']) {
            
            $this->transactionInit($config['connection']);
            
        }
        
        $result = database()->runModel([
            'model'=>$config['modelLoad'],
            'modelFunction'=>$config['modelFunction'],
            'path'=>$config['modelPath'],
            'connection'=>$config['connection'],
        ], $input, $config['modelParams']);
        exit(var_dump($result));
        
    }
    
}
