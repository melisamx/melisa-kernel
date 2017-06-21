<?php

namespace Melisa\Laravel\Criteria;

use Melisa\Repositories\Contracts\RepositoryInterface;

/**
 * Description of CriteriaInterface
 *
 * @author Luis Josafat Heredia Contreras
 */
interface CriteriaInterface
{
        
    public function apply($model, RepositoryInterface $repository, array $input = []);
    
}
