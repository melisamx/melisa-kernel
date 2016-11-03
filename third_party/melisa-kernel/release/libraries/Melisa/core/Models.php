<?php

namespace Melisa\core;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class Models extends Base
{
    
    public function __construct() {
        
        logger()->debug(__CLASS__ . ' Class Initialized');
        
    }
    
    public function load($models, $source = 'json') {
        
        if( is_array($models)) {
            
            $flag = TRUE;
            
            foreach($models as $model) {
                
                if( $this->load($model, $source)) {
                    
                    continue;
                    
                }
                
                $flag = FALSE;
                break;
                
            }
            
            return $flag;
            
        }
        
        return $this->get($models, FALSE, $source);
        
    }
    
    public function get($model, $return = FALSE, $source = 'json') {
        
        static $models = [];
        
        if( isset($models[$model])) {
            
            $this->setModelDefault($model);
            
            return $return ? $models[$model] : TRUE;
            
        }
        
        $modelData = $this->getCacheModel($model);
        
        if( $modelData) {
            
            $models [$model] = $modelData;
            $this->setModelDefault($model);
            
            return $return ? $models[$model] : TRUE;
            
        }
        
        if( !$this->getModelSource($model, $source)) {
            
            return FALSE;
            
        }
        
        return $this->get($model, $return, $source);
        
    }
    
    public function setModelDefault($model) {
        
        $this->modelDefault = $model;
        
    }
    
    public function getModelSource($model, $source) {
        
        $classLoad = __NAMESPACE__ . '\models\\' . ucfirst($source);
        
        return load()->libraries($classLoad)->create($model);
        
    }
    
    public function getCacheModel($item) {
        
        $cacheModel = cache()->get('models.' . $item);
        
        if( !$cacheModel) {
            
            return FALSE;
            
        }
        
        logger()->debug('{c}. Model {m} get success', [
            'c'=>__CLASS__,
            'm'=>$item
        ]);
        
        return $cacheModel;
        
    }
    
}
