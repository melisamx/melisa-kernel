<?php namespace Melisa\Laravel\Criteria;

use Melisa\Repositories\Criteria\Criteria;
use Melisa\Repositories\Contracts\RepositoryInterface;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class FilterCriteria extends Criteria
{
    
    public function apply($model, RepositoryInterface $repository, array $input = [])
    {
        
        if( !isset($input['filter'])) {
            
            return $model;
            
        }
        
        $filters = [];
        
        foreach($input['filter'] as $filter) {
            
            $operator = '=';
            
            if( isset($filter->operator)) {
                
                $operator = $filter->operator;
                
            }
            
            $filters []= [
                $filter->property, $operator, $filter->value
            ];
            
        }
        
        return $model->where($filters);
        
    }
    
}
