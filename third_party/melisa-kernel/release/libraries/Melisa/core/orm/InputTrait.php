<?php 

namespace Melisa\core\orm;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait InputTrait
{
    
    public function getConfig(array &$config = []) {
        
        $config = arrayDefault($config, [
            'modelLoad'=>NULL,
            'modelFunction'=>NULL,
            'modelPath'=>NULL,
            'modelParams'=>[],
            'modelValidation'=>NULL,
            'modelValidationDefault'=>NULL,
            'input'=>NULL,
            'inputSet'=>NULL,
            'inputValidate'=>TRUE,
            'filtersOnly'=>FALSE,
            'connection'=>NULL,
            'transaction'=>FALSE
        ]);
        
        if( is_null($config['modelValidation'])) {
            
            $config ['modelValidation']= $config['modelLoad'];
            
        }
        
        return $config;
        
    }
    
    public function getRequired(array &$config = []) {
        
        logger()->debug('{c}. Get input required', [
            'c'=>__CLASS__
        ]);
        
        return input()->get($config['input'], $config['inputSet']);
        
    }
    
    public function loadModelsValidations(&$config) {
        
        if( is_null($config['modelValidation'])) {
            
            return logger()->error('{c}. The model is not specific to validate input data', [
                'c'=>__CLASS__
            ]);
            
        }
        
        if( !model()->load($config['modelValidation'])) {
            
            return FALSE;
            
        }
        
        if( !is_array($config['modelValidation'])) {
            
            $config['modelValidation'] = [ $config['modelValidation'] ];
            
        }
        
        $modeloBase = $config['modelValidation'][0];
        
        if( !is_null($config['modelValidationDefault'])) {
            
            $modeloBase = $config['modelValidationDefault'];
            
        }
        
        $modeloDefault = array_keys($config['modelValidation'], $modeloBase);
        
        if( empty($modeloDefault)) {
            
            return logger()->error('The model validate default is invalid');
            
        }
        
        return model()->get($config['modelValidation'][$modeloDefault[0]], TRUE);      
        
    }
    
    public function isValidInput(array &$input = [], array &$config = []) {
        
        $modelValidation = $this->loadModelsValidations($config);
        
        if( !$modelValidation) {
            
            return FALSE;
            
        }
        
        if( !$config['inputValidate']) {
            
            logger()->debug('{c}. I was omitted validate input data', [
                'c'=>__CLASS__
            ]);
            
            return TRUE;
            
        }
        
        if( $config['filtersOnly']) {
            
            return load()->libraries('Melisa\core\input\FiltersData')
                ->withModel($input, $modelValidation);
            
        }
        
        $result = load()->libraries('Melisa\core\Validator')
                ->withModel($input, $modelValidation);
        
        if( !$result) {
            
            return FALSE;
            
        }
        
        return load()->libraries('Melisa\core\input\FiltersData')
                ->withModel($input, $modelValidation);
        
    }
    
}
