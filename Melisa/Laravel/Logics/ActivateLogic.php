<?php

namespace Melisa\Laravel\Logics;

/**
 * Activate logic basic with emit event
 *
 * @author Luis Josafat Heredia Contreras
 */
class ActivateLogic extends UpdateLogic
{
    
    protected $autoInyectIdentityCreated = false;
    protected $messageErrorInvalid = 'Registro invalido';
    protected $messageErrorAlready = 'El registro ya se encuentra activo';
    
    public function create(&$input)
    {
        if( !$this->isValid($input['id'])) {
            return false;
        }
        $input ['active']= true;
        return parent::create($input);
    }
    
    public function isValid($idUser)
    {
        $record = $this->repository->find($idUser);
        
        if( !$record) {
            return $this->error($this->messageErrorInvalid);
        }
        
        if( $record->active) {
            return $this->error($this->messageErrorAlready);
        }
        
        return true;
    }
    
}
