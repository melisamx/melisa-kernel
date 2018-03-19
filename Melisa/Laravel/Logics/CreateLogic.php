<?php

namespace Melisa\Laravel\Logics;

use Melisa\core\LogicBusiness;
use Melisa\Repositories\Contracts\RepositoryInterface;

/**
 * Create logic basic with emit event
 *
 * @author Luis Josafat Heredia Contreras
 */
class CreateLogic
{
    use LogicBusiness;
    
    protected $repository;
    protected $idField = 'id';
    protected $fireEvent;
    protected $disableFireEvent = false;
    protected $fieldIdIdentityCreated = 'idIdentityCreated';
    protected $autoInyectIdentityCreated = true;

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
    
    public function getAutoInyectIdentityCreated()
    {
        return $this->autoInyectIdentityCreated;
    }
    
    public function getIdentityCreated()
    {
        return $this->fieldIdIdentityCreated;
    }
    
    public function getFireEvent()
    {
        return $this->fireEvent;
    }
    
    public function init($input)
    {        
        $this->repository->beginTransaction();
        
        $this->inyectIdIdentityCreated($input);
        
        $idRecord = $this->save($input);
        
        if( !$idRecord) {
            return $this->repository->rollBack();
        }
        
        $event = $this->generateEvent($input, $idRecord);
        
        if( !$this->fireEvent($event)) {
            return $this->repository->rollBack();
        }
        
        $this->repository->commit();
        return $this->getReturnData($event, $input);
    }
    
    public function save(&$input)
    {
        return $this->create($input);
    }
    
    public function getReturnData(&$event, &$input)
    {
        if( isset($event['id'])) {
            return $this->repository->find($event['id'])->toArray();
        }
        
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
        
        if( $this->disableFireEvent) {
            $this->debug('Disable fire event');
            return true;
        }
        
        if( !$this->emitEvent($emitEvent, $event)) {
            return false;
        } else {
            return true;
        }        
    }
    
    public function disableFireEvent($disable = true)
    {
        $this->disableFireEvent = $disable;
        return $this;
    }
    
    public function inyectIdIdentityCreated(&$input)
    {        
        if( !$this->getAutoInyectIdentityCreated()) {
            return;
        }
        
        $input [$this->getIdentityCreated()]= $this->getIdentity();        
    }
    
    public function create(&$input)
    {        
        $result = $this->repository->create($input);
        
        if( $result === false) {
            return false;
        }
        
        if( isset($input['id'])) {
            return $input['id'];
        } else {            
            return is_numeric($result) ? $result : (isset($result->id) ? $result->id : $result) ;
        }        
    }
    
}
