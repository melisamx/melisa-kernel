<?php 

namespace Melisa\core\orm;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait InputTrait
{
    
    public function getConfig(array $config = []) {
        
        return array_default($config, [
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
        
    }
    
    public function getRequired(array &$config = []) {
        
        logger()->debug('{c}. Get input required', [
            'c'=>__CLASS__
        ]);
        
        return $this->input()->get($config['input'], $config['inputSet']);
        
    }
    
    public function loadModelsValidations(&$config) {
        exit(var_dump($config));
        if( is_null($config['modelValidation'])) {
            
            return logger()->error('{c}. The model is not specific to validate input data', [
                'c'=>__CLASS__
            ]);
            
        }
        
        if( !models()->load($config['modelValidation'])) {
            
            exit(var_dump('erro'));
        }
        exit(var_dump('ok'));
        if( is_null($config['modelValidationDefault'])) {
            
            
        }
        
    }
    
    public function isValidInput(array &$input = [], array &$config = []) {
        
        if( !$this->loadModelsValidations($config)) {
            
            exit(var_dump('er'));
        }
        exit(var_dump('ok'));
        if( !$config['inputValidate']) {
            
            logger()->debug('{c}. I was omitted validate input data', [
                'c'=>__CLASS__
            ]);
            
            return TRUE;
            
        }
        
        $model = [
            'columns'=>[
                'page'=>[
                    'validator'=>'numberPositive',
                    'size'=>10,
                    'required'=>TRUE
                ],
                'limit'=>[
                    'validator'=>'numberPositive',
                    'size'=>10,
                    'required'=>TRUE
                ],
                'start'=>[
                    'validator'=>'numberPositive',
                    'required'=>TRUE
                ],
                'active'=>[
                    'validator'=>'boolean',
                    'required'=>FALSE
                ],
                'comment'=>[
                    'validator'=>'text',
                    'required'=>FALSE,
                    'size'=>75,
                    'filters'=>'trim'
                ],
                'createdAt'=>[
                    'validator'=>'datetime',
                    'required'=>FALSE,
                ],
                'latitude'=>[
                    'validator'=>'double',
                    'required'=>FALSE,
                    'size'=>10
                ],
                'id'=>[
                    'validator'=>'uuid',
                    'required'=>FALSE
                ],
                'pass'=>[
                    'validator'=>'pass',
                    'required'=>TRUE,
                    'size'=>10,
                    'filters'=>'md5'
                ],
            ]
        ];
        
        if( $config['filtersOnly']) {
            
            return load()->libraries('Melisa\core\input\FiltersData')
                ->withModel($input, $model);
            
        }
        
        $result = load()->libraries('Melisa\core\Validator')
                ->withModel($input, $model);
        
        if( !$result) {
            
            return FALSE;
            
        }
        
        return load()->libraries('Melisa\core\input\FiltersData')
                ->withModel($input, $model);
        
    }
    
}
