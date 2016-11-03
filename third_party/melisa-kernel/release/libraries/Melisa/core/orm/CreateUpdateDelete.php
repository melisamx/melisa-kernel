<?php

namespace Melisa\core\orm;

use Melisa\core\database\GroupDatabaseTrait;
use Melisa\core\database\ConnectionsTrait;
use Melisa\core\orm\InputTrait;
use Melisa\core\orm\CacheTrait;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class CreateUpdateDelete
{
    
    use InputTrait, GroupDatabaseTrait, ConnectionsTrait, CacheTrait;
    
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
            'connection'=>$config['connection']
                
        ], $input, $config['modelParams']);
        
        if( $result === FALSE) {
            
            $this->cacheDelete($config, $input);
            $this->cacheDeleteRegex($config);
            
            if( isset($config['msgError'])) {
                
                logger()->error($config['msgError'], $input);
                
            }
            
            return FALSE;
            
        }
        
        $this->cacheDelete($config, $input);
        $this->cacheDeleteRegex($config);
        
        return $result;
        
    }
    
}
