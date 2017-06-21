<?php

namespace Melisa\Laravel\Logics;

use Melisa\core\LogicBusiness;
use Melisa\Repositories\Contracts\RepositoryInterface;

/**
 * Report logic
 *
 * @author Luis Josafat Heredia Contreras
 */
class ReportLogic
{    
    use LogicBusiness;
    
    protected $repository;

    public function __construct(
        RepositoryInterface $repo
    )
    {
        $this->repository = $repo;
    }
    
    public function init($id)
    {        
        $record = $this->getRecord($id);
        
        if( !$record) {
            return false;
        }
        
        $report = $record->toArray();        
        return json_decode(json_encode($report));
    }
    
    public function getRecord($id)
    {
        return $this->repository->findOrFail($id);
    }
    
}
