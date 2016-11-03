<?php

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class OrmCreate extends \CI_Model
{
    
    public function init(&$cnx, array &$input = [], &$params) {
        
        $data = [];
        
        foreach($input as $i=> &$record) {
            
            $data [$i]= $record;
            
        }
        
        $fieldPk = model()->getFieldPk();
        $table = model()->getTable();
        $fieldColumn = model()->getField($fieldPk);
        
        if( !$fieldPk || !$table || !$fieldColumn) {
            
            return FALSE;
            
        }
        
        if( !isset($data[$fieldPk]) && 
                isset($fieldColumn['isUuid']) && 
                $fieldColumn['isUuid']) {
            
            $data [$fieldPk] = uuid()->generate();
            
        }
        
        $query = $cnx->insert($table, $data);
        
        if( !$query) {
            
            return logger()->error('{c}. Imposible create record in database', [
                'c'=>__CLASS__
            ]);
            
        }
        
        logger()->debug('{c} Query success. {q}', [
            'c'=>__CLASS__,
            'q'=>PHP_EOL . $cnx->last_query()
        ]);
        
        if( isset($fieldColumn['isUuid']) && 
                $fieldColumn['isUuid'] && 
                isset($data[$fieldPk]) && 
                !is_null($data[$fieldPk])) {
            
            return $data[$fieldPk];
            
        }
        
        if( !isset($fieldColumn['autoIncrement'])) {
            
            return isset($data[$fieldPk]) ? $data[$fieldPk] : TRUE;
            
        } elseif( isset($fieldColumn['autoIncrement']) && $fieldColumn['autoIncrement']) {
            
            return (int)$cnx->insert_id();
            
        }
        
        return TRUE;
        
    }
    
}
