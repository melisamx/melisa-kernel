<?php

/**
 * Update record using model
 *
 * @author Luis Josafat Heredia Contreras
 */
class OrmUpdate extends \CI_Model
{
    
    public function init(&$cnx, array &$input = [], &$params = []) {
        
        $fieldPk = model()->getFieldPk();
        $table = model()->getTable();
        
        if( !$fieldPk || !$table) {
            
            return FALSE;
            
        }
        
        $fieldsUpdate = [];
        
        foreach($input as $i=> &$record) {
            
            if( $i == $fieldPk) {
                
                continue;
                
            }
                
            $fieldsUpdate [$i]= $record;

        }
        
        if( !isset($input[$fieldPk])) {
            
            return logger()->error('{c} Field PK no exist in input', [
                'c'=>__CLASS__
            ]);
            
        }
        
        $query = $cnx->where($fieldPk, $input[$fieldPk])
            ->update($table, $fieldsUpdate);
        
        if( $query) {
            
            return TRUE;
            
        }
        
        return logger()->error('{c}. Imposible update record', [
            'c'=>__CLASS__
        ]);
        
    }
    
}
