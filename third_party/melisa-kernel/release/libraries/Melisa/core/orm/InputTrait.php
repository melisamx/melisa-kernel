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
            'input'=>NULL,
            'inputSet'=>NULL,
            'inputValidate'=>TRUE,
            'filtersOnly'=>FALSE,
            'connection'=>NULL,
            'transaction'=>FALSE
        ]);
        
    }
    
    public function getRequired(array &$config = []) {
        
        $this->log()->debug('{c}. Get input required', [
            'c'=>__CLASS__
        ]);
        
        return $this->input()->get($config['input'], $config['inputSet']);
        
    }
    
    public function isValidInput(array &$input = [], array &$config = []) {
        
        if( !$config['inputValidate']) {
            
            $this->log()->debug('{c}. I was omitted validate input data', [
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
            
            return $this->load()->libraries('Melisa\core\input\FiltersData')
                ->withModel($input, $model);
            
        }
        
        $result = $this->load()->libraries('Melisa\core\Validator')
                ->withModel($input, $model);
        
        if( !$result) {
            
            return FALSE;
            
        }
        
        return $this->load()->libraries('Melisa\core\input\FiltersData')
                ->withModel($input, $model);
        
    }
    
}
