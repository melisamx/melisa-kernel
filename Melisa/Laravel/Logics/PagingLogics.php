<?php namespace Melisa\Laravel\Logics;

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
    
    public function __construct(RepositoryInterface $repository, $criteria = null) {
        
        $this->repository = $repository;
        $this->repositoryCriteria = $criteria;
        
    }
    
    public function init(array $input) {
        
        if( is_null($this->repositoryCriteria)) {
            
            $result = $this->repository->paginate($input['limit']);
            
        } else {
            
            $result = $this->repository
                    ->withCriteria($this->repositoryCriteria, $input)
                    ->paginate($input['limit']);
            
        }
        
        if( $result->total() === 0) {
            
            return response()->paging([
                'total'=>0,
                'data'=>[],
            ]);
            
        }
        
        return response()->paging([
            'total'=>$result->total(),
            'data'=>$result->toArray()['data']
        ]);
        
    }
    
}
