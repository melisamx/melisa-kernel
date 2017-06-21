<?php

namespace Melisa\Laravel\Criteria;

use Melisa\Repositories\Criteria\Criteria;
use Melisa\Repositories\Contracts\RepositoryInterface;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class FilterCriteria extends Criteria
{
    
    public function apply($model, RepositoryInterface $repository, array $input = [], array $fields = [])
    {        
        if( !isset($input['filter'])) {            
            return $model;            
        }
        
        $filters = [];        
        foreach($input['filter'] as $filter) {
            
            $operator = '=';
            $value = $filter->value;
            
            if( isset($filter->operator)) {
                $operator = $filter->operator;
                
                if($filter->operator === 'like') {
                    $value = '%' . $value . '%';
                }
                
            }
            
            if( isset($fields[$filter->property])) {
                $filters []= [
                    $fields[$filter->property], $operator, $value
                ];
            } else {
                $filters []= [
                    $filter->property, $operator, $value
                ];
            }            
            
        }
        
        return $model->where($filters);        
    }
    
}
