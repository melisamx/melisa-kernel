<?php

namespace Melisa\orm;

use Melisa\core\Crud;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class Users extends Crud
{
    
    public function readPaging(array $input = [], array $config = []) {
        
        return parent::readPaging($input, array_default($config, [
            'modelLoad'=>'users',
            'modelValidation'=>'users'
        ]));
        
    }
    
    
}
