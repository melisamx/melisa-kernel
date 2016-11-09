<?php

namespace Melisa\core\models;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class Json
{
    
    public function create($model) {
        
        $pathModel = loaderSearchFile($model, 'config/models', FALSE, '.json');
        
        if( !$pathModel) {
            
            return logger()->error('{c}. No exist file config model {m}', [
                'c'=>__CLASS__,
                'm'=>$model
            ]);
            
        }
        
        $modelData = $this->get($pathModel, $model);
        
        if( !$modelData) {
            
            return FALSE;
            
        }
        
        if( !$this->isValid($modelData, $model)) {
            
            return FALSE;
            
        }
        
        if( !$this->ajustModel($modelData)) {
            
            return FALSE;
            
        }
        
        if( !$this->save($modelData, $model)) {
            
            return FALSE;
            
        }
        
        return TRUE;
        
    }
    
    public function save(array &$modelData, $model) {
        
        $itemCache = "models.$model";
        
        $result = cache()->save($itemCache, $modelData);
        
        if( !$result) {
            
            return logger()->error('{c}. Imposible save in cache model {m}', [
                'c'=>__CLASS__,
                'm'=>$model
            ]);
            
        }
        
        logger()->debug('{c} Model {m} created and config success', [
            'c'=>__CLASS__,
            'm'=>$model
        ]);
        
        return TRUE;
        
    }
    
    public function ajustModel(array &$modelData = []) {
        
        $event = [ $modelData ];
        
        $result = event()->fire('core.models.before.ajust',$event);
        
        if( in_array(FALSE, $result)) {
            
            return FALSE;
            
        }
        
        $fieldsPk = [];
        
        foreach($modelData['columns'] as $column => &$value) {
            
            $columnConfig = arrayDefault(
                $modelData['columns'][$column], [
                    'required'=>TRUE,
                    'type'=>'numeric',
                    'size'=>10,
                    'field'=>$column
                ]
            );
            
            if( !isset($columnConfig['validator'])) {
                
                $columnConfig ['validator'] = $this->getValidator($columnConfig['type']);
                
            }
            
            if( in_array($columnConfig['type'], [
                'boolean',
                'datetime',
                'date'
            ])) {
                
                unset($columnConfig ['size']);
                
            }
            
            if( isset($columnConfig['isPrimaryKey'])) {
                
                $fieldsPk []= $column;
                
            }
            
            $modelData['columns'][$column] = $columnConfig;
            
        }
        
        $modelData ['primaryKeys']= $fieldsPk;
        
        return TRUE;
        
    }
    
    public function getValidator($type) {
        
        $validator = 'numberPositive';
        
        switch($type) {
            
            case 'string':
                $validator = 'text';
                break;
            
            case 'decimal':
                $validator = 'double';
                break;
            
            case 'boolean':
                $validator = 'boolean';
                break;
            
            case 'datetime':
                $validator = 'datetime';
                break;
            
            case 'email':
                $validator = 'email';
                break;
            
            case 'time':
                $validator = 'time';
                break;
            
        }
        
        return $validator;
        
    }
    
    public function isValid(&$modelData, $model) {
        
        if( isset($modelData['table'], $modelData['columns'])) {
            
            return TRUE;
            
        }
        
        return logger()->error('{c}. Model {m} data is invalid', [
            'c'=>__CLASS__,
            'm'=>$model
        ]);
        
    }
    
    public function get($pathModel, $model) {
        
        $pathFile = $pathModel . $model . '.json';
        
        $modelData = fs()->read($pathFile)->toJson();
        
        if( !$modelData) {
            
            return logger()->error('{c}. Imposible read config model {m}', [
                'c'=>__CLASS__,
                'm'=>$pathFile
            ]);
            
        }
        
        return $modelData;
        
    }
    
}
