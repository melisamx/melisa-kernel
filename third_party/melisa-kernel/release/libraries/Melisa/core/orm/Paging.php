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
class Paging
{
    use InputTrait, GroupDatabaseTrait, ConnectionsTrait;
    
    public function init(array $config = []) {
        
        $config = $this->getConfig($config);
        
        $input = $this->getRequired($config);
        
        if( !$input) {
            
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
            'function'=>$config['modelFunction'],
            'path'=>$config['modelPath'],
            'connection'=>$config['connection'],
            'modelDefault'=>$config['modelDefault']
        ], $input, $config['modelParams']);
        
        if( $result === FALSE) {
            
            if( isset($config['msgError'])) {
                
                logger()->error($config['msgError'], $input);
                
            }
            
            return FALSE;
            
        }
        
        return $result;
        
    }
    
}
