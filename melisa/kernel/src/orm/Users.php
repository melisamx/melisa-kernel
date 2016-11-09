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
    
    public function paging(array $input = [], array $config = []) {
        
        return parent::paging($input, arrayDefault($config, [
            'modelValidation'=>[
                '_core',
                'users'
            ],
            'modelDefault'=>'users'
        ]));
        
    }
    
    public function delete($id = NULL, array $config = []) {
        
        return parent::delete($id, arrayDefault($config, [
            'modelValidation'=>'users'
        ]));
        
    }
    
    public function create(array $input = [], array $config = []) {
        
        return parent::create($input, arrayDefault($config, [
            'modelValidation'=>'users',
            'inputSet'=>$input,
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
                'updatedAt'=>[
                    'required'=>FALSE
                ]
            ]
        ]));
        
    }
    
    public function update(array $input = [], array $config = []) {
        
        return parent::update($input, arrayDefault($config, [
            'modelValidation'=>'users',
            'inputSet'=>$input,
            'input'=>[
                'id',
                'name',
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
                'updatedAt'=>[
                    'default'=>'CURRENT_TIMESTAMP'
                ]
            ]
        ]));
        
    }
    
}