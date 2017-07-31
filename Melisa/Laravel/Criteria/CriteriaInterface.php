<?php

namespace Melisa\Laravel\Criteria;

/**
 * Description of CriteriaInterface
 *
 * @author Luis Josafat Heredia Contreras
 */
interface CriteriaInterface
{
        
    public function apply($model, $repository, array $input = []);
    
}
