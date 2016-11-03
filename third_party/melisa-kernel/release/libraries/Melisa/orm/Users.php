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
        
        return parent::readPaging($input, arrayDefault($config, [
            'modelLoad'=>'users'
        ]));
        
    }
    
    public function create(array $input = [], array $config = []) {
        
        return parent::create($input, arrayDefault($config, [
            'input'=>[
                'name',
                'password',
                'createdAt'=>[
                    'default'=>'CURRENT_TIMESTAMP'
                ],
                'active'=>[
                    'default'=>TRUE
                ],
                'isSystem'=>[
                    'default'=>TRUE
                ],
                'firstLogin'=>[
                    'default'=>FALSE
                ],
                'changePassword'=>[
                    'default'=>FALSE
                ],
                'isGod'=>[
                    'default'=>FALSE
                ],
                'updateAt'=>[
                    'required'=>FALSE
                ]
            ],
            'inputSet'=>$input,
            'modelValidation'=>'users'
        ]));
        
    }
    
    
}
