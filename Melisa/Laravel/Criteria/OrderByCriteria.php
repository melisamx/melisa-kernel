<?php

namespace Melisa\Laravel\Criteria;

use Melisa\Laravel\Criteria\FilterCriteria;
use Melisa\Repositories\Contracts\RepositoryInterface;

/**
 * Order by field criteria
 *
 * @author Luis Josafat Heredia Contreras
 */
class OrderByCriteria extends FilterCriteria
{
    
    protected $fieldOrder = 'name';
    
    public function setFieldOrder($field)
    {
        $this->fieldOrder = $field;
        return $this;
    }

    public function apply($model, RepositoryInterface $repository, array $input = [])
    {
        $builder = parent::apply($model, $repository, $input);        
        return $builder->orderBy($this->fieldOrder);
    }
}
