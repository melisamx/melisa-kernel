<?php

namespace Melisa\core;

use Melisa\contracts\orm\CrudInterface;
//use Melisa\core\orm\Paging;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Crud extends LogicBusiness implements CrudInterface
{
    
    public function create(array $input = [], array $config = []) {
        
    }
    
    public function readPaging(array $input = [], array $config = []) {
        
        return $this->load()->libraries(__NAMESPACE__ . '\orm\Paging')
            ->init(array_default($config, [
                'input'=>[
                    'start',
                    'limit',
                    'page',
                ],
                'inputSet'=>$input
            ]));
        
    }
    
    public function readById($id, array $config = []) {
        
    }
    
    public function update(array $input = [], array $config = []) {
        
    }
    
    public function delete($id, array $config = []) {
        
        
    }
    
}
