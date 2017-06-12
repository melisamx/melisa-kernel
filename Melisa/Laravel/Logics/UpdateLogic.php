<?php

namespace Melisa\Laravel\Logics;

/**
 * Update logic basic with emit event
 *
 * @author Luis Josafat Heredia Contreras
 */
class UpdateLogic extends CreateLogic
{
    
    public function create(&$input)
    {        
        $result = $this->repository->update($input, $this->getInputId($input));
        
        if( $result === false) {
            return false;
        }
        
        if( isset($input['id'])) {
            return $input['id'];
        } else {
            return $result;
        }        
    }
    
    public function getInputId($input)
    {
        $idField = $this->getIdField();
        
        if( isset($input[$idField])) {
            return $input[$idField];
        }
        return $input;
    }
    
}
