<?php

/**
 * Create record using model
 *
 * @author Luis Josafat Heredia Contreras
 */
class OrmDelete extends \CI_Model
{
    
    public function init(&$cnx, array &$input = [], &$params = []) {
        
        $fieldPk = model()->getFieldPk();
        $ids = [];
        
        if( is_array($input[$fieldPk])) {
            
            foreach($input[$fieldPk] as $id) {
                
                $ids []= $id;
                
            }
            
        } else {
            
            $ids []= $input[$fieldPk];
            
        }
        
        $cnx->where_in($fieldPk, $ids);
        
        if( isset($params['where'])) {
            
            if( !$this->addWhere($cnx, $input, $params)) {
                
                return FALSE;
                
            }
            
        }
        
        $query = $cnx->delete(model()->getTable());
        
        if( $query) {
            
            return TRUE;
            
        }
        
        return logger()->error('{c}. Imposible delete record(s)', [
            'c'=>__CLASS__
        ]);
        
    }
    
    public function addWhere(&$cnx, array &$input, array &$params) {
        
        $flag = TRUE;
        
        foreach($params['where'] as $field=>$value) {
            
            if( !isset($input[$field])) {
                
                logger()->error('Field "{f}" no exist in input', [
                    'f'=>$field
                ]);
                
                $flag = FALSE;
                continue;
                
            }
            
            $cnx->where($field, $input[$field]);
            
        }
        
        return $flag;
        
    }
    
}
