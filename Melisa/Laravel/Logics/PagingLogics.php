<?php

namespace Melisa\Laravel\Logics;

use Melisa\core\LogicBusiness;
use Melisa\Repositories\Contracts\RepositoryInterface;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class PagingLogics
{
    use LogicBusiness;
    
    protected $repository;
    protected $repositoryCriteria;
    
    public function __construct(RepositoryInterface $repository, $criteria = null)
    {        
        $this->repository = $repository;
        $this->repositoryCriteria = $criteria;        
    }
    
    public function init(array $input)
    {
        if( !isset($input['limit'])) {
            $input ['limit']= 25;
        }
        
        $result = $this->runQuery($input);
        
        if( !$result) {
            return false;
        }
        
        if( $result->total() === 0) {            
            return $this->returnDataEmpty();            
        }
        
        return $this->returnData($result, $input); 
    }
    
    public function returnDataEmpty()
    {
        return [
            'total'=>0,
            'data'=>[],
        ];
    }
    
    public function returnData(&$result, &$input)
    {
        return [
            'total'=>$result->total(),
            'data'=>$result->toArray()['data']
        ];
    }
    
    public function runQuery(&$input)
    {        
        if( is_null($this->repositoryCriteria)) {            
            $result = $this->repository->paginate((int)$input['limit']);            
        } else {            
            $result = $this->repository
                ->withCriteria($this->repositoryCriteria, $input)
                ->paginate((int)$input['limit']);
        }
        
        return $result;
    }
    
}
