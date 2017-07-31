<?php

namespace Melisa\Repositories\Criteria;

use Melisa\Laravel\Criteria\CriteriaInterface;

abstract class Criteria implements CriteriaInterface
{

    /**
     * @param $model
     * @param Repository $repository
     * @return mixed
     */
    public abstract function apply($model, $repository, array $input = []);
    
}
