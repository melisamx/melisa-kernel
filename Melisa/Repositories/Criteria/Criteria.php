<?php namespace Melisa\Repositories\Criteria;

use Melisa\Repositories\Contracts\RepositoryInterface as Repository;

abstract class Criteria {

    /**
     * @param $model
     * @param Repository $repository
     * @return mixed
     */
    public abstract function apply($model, Repository $repository, array $input = []);
    
}
