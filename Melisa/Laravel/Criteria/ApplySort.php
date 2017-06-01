<?php

namespace Melisa\Laravel\Criteria;

use Melisa\Repositories\Contracts\RepositoryInterface;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait ApplySort
{
    
    public function applySort($model, array $input = [])
    {        
        if( !isset($input['sort'])) {            
            return $model;            
        }
        
        $sorter = json_decode($input['sort']);
        
        foreach($sorter as $sort) {
            
            $model = $model->orderBy($sort->property, $sort->direction);
            
        }
        
        return $model;        
    }
    
}
