<?php

namespace Melisa\core;

use Melisa\contracts\orm\CrudInterface;

/* 
 * Crud operations in table
 */
class Crud implements CrudInterface
{
    
    public function create(array $input = [], array $config = []) {
        
        return load()->libraries(__NAMESPACE__ . '\orm\CreateUpdateDelete')
            ->init(arrayDefault($config, [
                'inputSet'=>$input,
                'modelLoad'=>'OrmCreate'
            ]));
        
    }
    
    public function paging(array $input = [], array $config = []) {
        
        return load()->libraries(__NAMESPACE__ . '\orm\Paging')
            ->init(arrayDefault($config, [
                'input'=>[
                    'start'=>[
                        'type'=>'GET'
                    ],
                    'limit'=>[
                        'type'=>'GET'
                    ],
                    'page'=>[
                        'type'=>'GET'
                    ],
                ],
                'inputSet'=>$input,
                'modelLoad'=>'OrmPaging',
                'modelValidation'=>'_core'
            ]));
        
    }
    
    public function readById($id, array $config = []) {
        
        return load()->libraries(__NAMESPACE__ . '\orm\ReadCache')
            ->init(arrayDefault($config, [
                'input'=>[
                    'id'
                ],
                'inputSet'=>$id,
                'modelLoad'=>'OrmReadById'
            ]));
        
    }
    
    public function update(array $input = [], array $config = []) {
        
        return load()->libraries(__NAMESPACE__ . '\orm\CreateUpdateDelete')
            ->init(arrayDefault($config, [
                'inputSet'=>$input,
                'modelLoad'=>'OrmUpdate'
            ]));
        
    }
    
    public function delete($id = NULL, array $config = []) {
        
        return load()->libraries(__NAMESPACE__ . '\orm\CreateUpdateDelete')
            ->init(arrayDefault($config, [
                'input'=>[
                    'id'
                ],
                'inputSet'=>$id,
                'modelLoad'=>'OrmDelete'
            ]));
        
    }
    
}
