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
        
        if( $this->getModel($models, $source)) {
            
            return TRUE;
            
        }
        
    }
    
    public function getModel($model, $return = FALSE, $source = 'json') {
        
        static $models = [];
        
        if( isset($models[$model])) {
            
            $this->setModelDefault($model);
            
            return $return ? $models[$model] : TRUE;
            
        }
        
        if( $this->getCacheModel($model)) {
            
            return TRUE;
            
        }
        
        if( !$this->getModelSource($model, $source)) {
            
            return FALSE;
            
        }
        
        return $this->getCacheModel($model);
        
    }
    
    public function getModelSource($model, $source) {
        
        $classLoad = __NAMESPACE__ . '\models\\' . ucfirst($source);
        
        return load()->libraries($classLoad)->create($model);
        
    }
    
    public function getCacheModel($item) {
        
        $cacheModel = cache()->get('models.' .$item);
        exit(var_dump($cacheModel));
        if( !$cacheModel) {
            
            return FALSE;
            
        }
        
        logger()->debug('{c}. Model get success: m', [
            'c'=>__CLASS__,
            'm'=>$item
        ]);
        
        return $cacheModel;
        
    }
    
}
