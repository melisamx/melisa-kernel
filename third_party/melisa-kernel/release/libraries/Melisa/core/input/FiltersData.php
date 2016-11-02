<?php

namespace Melisa\core\input;

use Melisa\core\Base;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class FiltersData extends Base
{
    
    public function withModel(&$fields, array &$model) {
        
        $flag = TRUE;
        
        foreach($fields as $field => &$value) {
            
            if( !isset($model['columns'][$field])) {
                
                $flag = $this->log()->error('{c}. Field {f} no exist in model', [
                    'c'=>__CLASS__,
                    'f'=>$field
                ]);
                break;
                
            }
            
            if( !isset($model['columns'][$field]['filters'])) {
                
                continue;
                
            }
            
            if( $this->applyFilterField($field, $value, $model['columns'][$field])) {
                
                continue;
                
            }
            
            $flag = FALSE;
            break;
            
        }
        
        return $flag;
        
    }
    
    public function applyFilterField($field, &$value = NULL, array &$model) {
        
        if( !is_array($model['filters'])) {
            
            $model ['filters']= [ $model['filters'] ];
            
        }
        
        $flag = TRUE;
        
        foreach($model['filters'] as $filter) {
            
            $filterFunction = 'f' . ucfirst($filter);
            
            if( !method_exists($this, $filterFunction)) {
                
                $this->log()->error('{c}. Filter {f} not suported', [
                    'c'=>__CLASS__,
                    'f'=>$filter
                ]);
            
                $flag = FALSE;
                break;
                
            }
            
            $result = $this->{$filterFunction}($value, $model);
            
            if( $result) {
                
                continue;
                
            }
            
            $flag = FALSE;
            break;
            
        }
        
        return $flag;
        
    }
    
    public function fTrim(&$value, &$model) {
        
        $value = trim($value);
        
        return TRUE;
        
    }
    
    public function fMd5(&$value, &$model) {
        
        if( is_null($value)) {
            
            return TRUE;
            
        }
        
        $value = md5($value);
        
        return TRUE;
        
    }
    
    public function fUppercase(&$value, &$model) {
        
        if( !is_array($value)) {
                        
            /* convert correct acentos and eñes */
            $value = mb_convert_case($value, MB_CASE_UPPER, 'UTF-8');
            return TRUE;
            
        }

        foreach($value as $i => &$val) {

            $this->fUppercase($val, $model);

        }
        
        return TRUE;
        
    }
    
}
