<?php

/**
 * Paging using model
 *
 * @author Luis Josafat Heredia Contreras
 */
class OrmPaging extends \CI_Model
{
    
    public function init(&$cnx, array &$in, &$par = []) {
        
        $table = model()->getTable();
        
        return $this->paging($table, $cnx, $in, $par);
        
    }
    
    public function paging($table, &$cnx, &$in, &$par) {
        
        $total = $this->getTotal($table, $cnx, $in, $par);
        
        if( $total === FALSE) {
            
            return FALSE;
            
        }
        
        if( (int)$total['id'] === 0) {
            
            return [
                'totalRecords'=>0,
                'records'=>[]
            ];
            
        }
        
        $records = $this->getRecords($table, $cnx, $in, $par);
        
        if( $records === FALSE) {
            
            return logger()->error('Imposible obtener los identificadores paginados');
            
        }
        
        return [
            'totalRecords'=>$total['id'],
            'records'=>$records
        ];
        
    }
    
    public function setCriterios(&$connection, &$input, &$params) {
        
        
    }
    
    public function getFields() {
        
        return '*';
        
    }
    
    public function buildOrder(&$cnx, &$orders) {
        
        if( !$orders) {
            
            logger()->debug('No se especifico campos de ordenado, se ignora ordenar');
            return TRUE;
            
        }
        
        foreach($orders as $field => $order) {
            
            $cnx->order_by($field, $order);
            
        }
        
    }
    
    public function setOrder(&$cnx, &$in, &$par) {
        
        
    }
    
    /**
     * Requerido para consultas personalizadas
     * @return boolean
     */
    public function protectFields() {
        
        return TRUE;
        
    }
    
    public function getRecords($table, &$cnx, &$input, &$params) {
        
        $fields = $this->getFields();
        
        if( is_array($fields)) {
            
            $cnx->select(implode(',', $fields), $this->protectFields());
            
        } else {
            
            $cnx->select($fields, $this->protectFields());
            
        }
        
        $this->setCriterios($cnx, $input, $params);
        
        $this->setOrder($cnx, $input, $params);
        
        $query = $cnx->get($table, 
            isset($input['limit']) ? $input['limit'] : NULL, 
            isset($input['start']) ? $input['start'] : NULL);
        
        if( !$query) {
            
            return FALSE;
            
        }
        
        return $query->result_array();
        
    }
    
    public function getFieldTotal() {
        
        return 'COUNT(*) as id';
        
    }
    
    public function getTotal($table, &$cnx, &$in, &$par) {
        
        $cnx->select($this->getFieldTotal());
        
        $this->setCriterios($cnx, $in, $par);
        
        $query = $cnx->get($table);
        
        if( !$query) {
            
            return FALSE;
            
        }
        
        logger()->debug('{c} SQL total records success {t}', [
            'c'=>__CLASS__,
            't'=>PHP_EOL . $cnx->last_query()
        ]);
        
        return $query->row_array();
        
    }
    
    public function format(&$records) {
        
        
        
    }
    
}
