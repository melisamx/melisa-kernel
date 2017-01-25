<?php namespace Melisa\Laravel\Logics;

use Melisa\core\LogicBusiness;
use Melisa\Repositories\Contracts\RepositoryInterface;

/**
 * Delete logic basic with emit event
 *
 * @author Luis Josafat Heredia Contreras
 */
class DeleteLogic
{
    use LogicBusiness;
    
    protected $repository;
    protected $idField = 'id';
    protected $fireEvent;

    public function __construct(
        RepositoryInterface $repo
    )
    {
        $this->repository = $repo;
    }
    
    public function setIdField($id)
    {
        $this->idField = $id;
        return $this;
    }
    
    public function setEmitEvent($id)
    {
        $this->idField = $id;
        return $this;
    }
    
    public function setFireEvent($event)
    {
        $this->fireEvent = $event;
        return $this;
    }
    
    public function getIdField()
    {
        return $this->idField;
    }
    
    public function getFireEvent()
    {
        return $this->fireEvent;
    }
    
    public function init($input)
    {
        
        $this->repository->beginTransaction();
        
        $idRecord = $this->delete($input);
        
        if( !$idRecord) {
            return $this->repository->rollBack();
        }
        
        $event = $this->generateEvent($input, $idRecord);
        
        if( !$this->fireEvent($event)) {
            return $this->repository->rollBack();
        }
        
        $this->repository->commit();
        return $event;
        
    }
    
    public function generateEvent($input, $idRecord)
    {
        
        return [
            $this->getIdField()=>$idRecord
        ];
        
    }
    
    public function fireEvent(array $event)
    {
        
        $emitEvent = $this->getFireEvent();
        
        if( empty($emitEvent)) {
            return true;
        }
        
        if( !$this->emitEvent($emitEvent, $event)) {
            return false;
        } else {
            return true;
        }
        
    }
    
    public function delete(&$input)
    {
        
        return $this->repository->delete($input);
        
    }
    
}
