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
        
        logger()->debug('{c} Model {m} get success', [
            'c'=>__CLASS__,
            'm'=>$item
        ]);
        
        return $cacheModel;
        
    }
    
    public function getFieldPk($modelName = NULL) {
        
        if( is_null($modelName)) {
            
            $modelName = $this->modelDefault;
            
        }
        
        $model = $this->get($modelName, TRUE);
        
        if( !$model) {
            
            return FALSE;
            
        }
        
        if( empty($model['primaryKeys'])) {
            
            logger()->info('{c}. Model {m} without primary key', [
                'c'=>__CLASS__,
                'm'=>$modelName
            ]);
            
            return FALSE;
            
        }
        
        if( count($model['primaryKeys']) === 1) {
            
            return $model['primaryKeys'][0];
            
        }
        
        return $model['primaryKeys'];
        
    }
    
    public function getField($field, $modelName = NULL) {
        
        if( is_null($modelName)) {
            
            $modelName = $this->modelDefault;
            
        }
        
        $model = $this->get($modelName, TRUE);
        
        if( !$model) {
            
            return logger()->error('{c}. The model {m} no exist', [
                'c'=>__CLASS__,
                'm'=>$modelName
            ]);
            
        }
        
        if( isset($model['columns'][$field])) {
            
            return $model['columns'][$field];
            
        }
        
        return logger()->error('{c}. The field {f} no exist in model {m}', [
            'c'=>__CLASS__,
            'f'=>$field,
            'm'=>$modelName
        ]);
        
    }
    
    public function getTable($modelName = NULL) {
        
        if( is_null($modelName)) {
            
            $modelName = $this->modelDefault;
            
        }
        
        $model = $this->get($modelName, TRUE);
        
        if( $model) {
            
            return $model['table'];
            
        }
        
        return logger()->error('{c}. The model {m} no exist', [
            'c'=>__CLASS__,
            'm'=>$modelName
        ]);
        
    }
    
}
