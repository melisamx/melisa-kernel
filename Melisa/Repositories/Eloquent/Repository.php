<?php

namespace Melisa\Repositories\Eloquent;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Melisa\Repositories\Contracts\RepositoryInterface;
use Melisa\Repositories\Exceptions\RepositoryException;
use Melisa\Repositories\Contracts\CriteriaInterface;
use Melisa\Repositories\Criteria\Criteria;
use Melisa\core\orm\ErrorHumanTrait;

/**
 * Class Repository
 * @package Melisa\Repositories\Eloquent
 */
abstract class Repository implements RepositoryInterface, CriteriaInterface
{
    use ErrorHumanTrait;

    /**
     * @var App
     */
    private $app;

    /**
     * @var
     */
    protected $model;

    protected $newModel;

    /**
     * @var Collection
     */
    protected $criteria;

    /**
     * @var Collection
     */
    protected $builderCriteria;

    /**
     * @var bool
     */
    protected $skipCriteria = false;

    /**
     * Prevents from overwriting same criteria in chain usage
     * @var bool
     */
    protected $preventCriteriaOverwriting = true;

    /**
     * @param App $app
     * @param Collection $collection
     * @throws \Melisa\Repositories\Exceptions\RepositoryException
     */
    public function __construct(App $app, Collection $collection)
    {
        $this->app = $app;
        $this->criteria = $collection;
        $this->resetScope();
        $this->makeModel();
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public abstract function model();

    /**
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*'))
    {
        $this->applyCriteria();
        return $this->model->get($columns);
    }
    
    public function getModel()
    {
        
        return $this->model;
        
    }

    /**
     * @param array $relations
     * @return $this
     */
    public function with(array $relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * @param  string $value
     * @param  string $key
     * @return array
     */
    public function lists($value, $key = null)
    {
        $this->applyCriteria();
        $lists = $this->getBuilderOrModel()->lists($value, $key);
        if (is_array($lists)) {
            return $lists;
        }
        return $lists->all();
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 25, $columns = array('*'))
    {
        $this->applyCriteria();
        
        return $this->getBuilderOrModel()->paginate($perPage, $columns);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        /**
         * necesary use in seeder class
         */
        if( $this->model->isUnguarded()) {
            
            $this->model->reguard();
            
        }
        
        return $this->model->create($data);
    }

    /**
     * save a model without massive assignment
     *
     * @param array $data
     * @return bool
     */
    public function saveModel(array $data)
    {
        foreach ($data as $k => $v) {
            $this->model->$k = $v;
        }
        return $this->model->save();
    }

    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function update(array $data, $id, $attribute = "id")
    {
        $input = array_only($data, $this->getModel()->getFillable());
        try
        {
            $result = $this->model->where($attribute, '=', $id)->update($input);
        } catch (QueryException $ex) {
            $result = false;
            melisa('logger')->error(static::errorHuman($ex->getMessage(), $ex->errorInfo, $input));
        }
        return $result;
    }

    /**
     * @param  array $data
     * @param  $id
     * @return mixed
     */
    public function updateRich(array $data, $id)
    {
        if (!($model = $this->model->find($id))) {
            return false;
        }

        return $model->fill($data)->save();
    }

    /**
     * @param  array $data
     * @param  $id
     * @return mixed
     */
    public function updateOrCreate(array $findFields, array $values = [])
    {   
        try
        {
            $result = $this->model->updateOrCreate($findFields, $values); 
        } catch (QueryException $ex) {
            $result = false;
            melisa('logger')->error(static::errorHuman($ex->getMessage(), $ex->errorInfo, $input));
        }
        
        return $result;     
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'))
    {
        $this->applyCriteria();
        return $this->getBuilderOrModel()->find($id, $columns);
    }
        
    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function findOrFail($id, $columns = array('*'))
    {
        $this->applyCriteria();
        $record = $this->getBuilderOrModel()->find($id, $columns);
        
        if( is_null($record)) {
            
            return false;
            
        }
        
        return $record;        
    }
    
    private function getBuilderOrModel()
    {        
        if( $this->builderCriteria instanceof Builder) {
            return $this->builderCriteria;
        } else {
            return $this->model;
        }        
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*'))
    {
        $this->applyCriteria();
        return $this->getBuilderOrModel()->where($attribute, '=', $value)->first($columns);
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findAllBy($attribute, $value, $columns = array('*'))
    {
        $this->applyCriteria();
        return $this->getBuilderOrModel()->where($attribute, '=', $value)->get($columns);
    }

    /**
     * Find a collection of models by the given query conditions.
     *
     * @param array $where
     * @param array $columns
     * @param bool $or
     *
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function findWhere($where, $columns = ['*'], $or = false)
    {
        $this->applyCriteria();

        $model = $this->getBuilderOrModel();

        foreach ($where as $field => $value) {
            if ($value instanceof \Closure) {
                $model = (!$or)
                    ? $model->where($value)
                    : $model->orWhere($value);
            } elseif (is_array($value)) {
                if (count($value) === 3) {
                    list($field, $operator, $search) = $value;
                    $model = (!$or)
                        ? $model->where($field, $operator, $search)
                        : $model->orWhere($field, $operator, $search);
                } elseif (count($value) === 2) {
                    list($field, $search) = $value;
                    $model = (!$or)
                        ? $model->where($field, '=', $search)
                        : $model->orWhere($field, '=', $search);
                }
            } else {
                $model = (!$or)
                    ? $model->where($field, '=', $value)
                    : $model->orWhere($field, '=', $value);
            }
        }
        return $model->get($columns);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws RepositoryException
     */
    public function makeModel()
    {
        return $this->setModel($this->model());
    }

    /**
     * Set Eloquent Model to instantiate
     *
     * @param $eloquentModel
     * @return Model
     * @throws RepositoryException
     */
    public function setModel($eloquentModel)
    {
        $this->newModel = $this->app->make($eloquentModel);

        if (!$this->newModel instanceof Model)
            throw new RepositoryException("Class {$this->newModel} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        return $this->model = $this->newModel;
    }

    /**
     * @return $this
     */
    public function resetScope()
    {
        $this->skipCriteria(false);
        return $this;
    }

    /**
     * @param bool $status
     * @return $this
     */
    public function skipCriteria($status = true)
    {
        $this->skipCriteria = $status;
        $this->builderCriteria = null;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * @param Criteria $criteria
     * @return $this
     */
    public function getByCriteria(Criteria $criteria, array $input = [])
    {        
        $result = $criteria->apply($this->model, $this, $input);
        
        if( $result instanceof Builder) {
            return $result->get();
        }
        
        return $this;        
    }
    
    public function withCriteria(Criteria $criteria, array $input = [])
    {        
        $result = $criteria->apply($this->model, $this, $input);
        
        if( $result instanceof Builder) {
            $this->builderCriteria = $result;
            return $this;
        }
        
        return $this;        
    }

    /**
     * @param Criteria $criteria
     * @return $this
     */
    public function getByCriteriaReset(Criteria $criteria, array $input = [])
    {
        return $criteria->apply($this->model, $this, $input);
    }

    /**
     * @param Criteria $criteria
     * @return $this
     */
    public function pushCriteria(Criteria $criteria)
    {
        if ($this->preventCriteriaOverwriting) {
            // Find existing criteria
            $key = $this->criteria->search(function ($item) use ($criteria) {
                return (is_object($item) && (get_class($item) == get_class($criteria)));
            });

            // Remove old criteria
            if (is_int($key)) {
                $this->criteria->offsetUnset($key);
            }
        }

        $this->criteria->push($criteria);
        return $this;
    }

    /**
     * @return $this
     */
    public function applyCriteria()
    {
        if ($this->skipCriteria === true)
            return $this;

        foreach ($this->getCriteria() as $criteria) {
            if ($criteria instanceof Criteria)
                $this->builderCriteria = $criteria->apply($this->model, $this);
        }

        return $this;
    }
    
    public function beginTransaction()
    {        
        $this->model->getConnection()->beginTransaction();        
    }
    
    public function commit()
    {        
        $this->model->getConnection()->commit();        
    }
    
    public function rollBack()
    {        
        $this->model->getConnection()->rollBack();
        return false;        
    }
    
    public function debugLastQuery()
    {        
        $queries = $this->model
                ->getConnection()
                ->getQueryLog();        
        $lastQuery = end($queries);        
        return melisa('logger')->debug($lastQuery['query']);        
    }
            
}