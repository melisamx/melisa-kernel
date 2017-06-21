<?php

namespace Melisa\Repositories\Criteria;

use Melisa\Repositories\Contracts\RepositoryInterface as Repository;
use Melisa\Laravel\Criteria\CriteriaInterface;

abstract class Criteria implements CriteriaInterface
{

    /**
     * @param $model
     * @param Repository $repository
     * @return mixed
     */
    public abstract function apply($model, Repository $repository, array $input = []);
    
}
