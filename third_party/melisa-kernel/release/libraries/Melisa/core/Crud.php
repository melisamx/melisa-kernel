<?php

namespace Melisa\core;

use Melisa\contracts\orm\CrudInterface;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
    
    public function readPaging(array $input = [], array $config = []) {
        
        return load()->libraries(__NAMESPACE__ . '\orm\Paging')
            ->init(arrayDefault($config, [
                'input'=>[
                    'start',
                    'limit',
                    'page',
                ],
                'inputSet'=>$input,
                'modelLoad'=>'OrmPaging'
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
