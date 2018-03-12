<?php

namespace Melisa\Laravel\Criteria;

use Melisa\Repositories\Criteria\Criteria;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class FilterCriteria extends Criteria
{
    
    public function apply($model, $repository, array $input = [], array $fields = [])
    {        
        if( !isset($input['filter'])) {            
            return $model;            
        }
        
        $filters = [];        
        foreach($input['filter'] as $filter) {
            
            $operator = '=';
            $value = $filter->value;
            $overridFilter = 'overrideFilter' . ucfirst($filter->property);
            
            if( method_exists($this, $overridFilter)) {
                $model = $this->{$overridFilter}($model, $filter, $input);
                continue;
            }
            
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
    
    public function existFilter($filter, &$input)
    {
        if( !isset($input['filter'])) {
            return false;
        }
        
        $exist = collect($input['filter'])
            ->where('property', $filter)
            ->first();
        
        return $exist ? true : false;
    }
    
}
