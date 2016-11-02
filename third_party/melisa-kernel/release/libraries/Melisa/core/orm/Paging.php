<?php 

namespace Melisa\core\orm;

use Melisa\core\LogicBusiness;
use Melisa\core\database\GroupDatabaseTrait;
use Melisa\core\database\ConnectionsTrait;
use Melisa\core\orm\InputTrait;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class Paging extends LogicBusiness
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
        
        $result = $this->db()->runModel([
            'model'=>$config['modelLoad'],
            'function'=>$config['modelFunction'],
            'path'=>$config['modelPath'],
            'connection'=>$config['connection'],
        ], $input, $config['modelParams']);
        exit(var_dump($result));
        return TRUE;
        
    }
    
}
