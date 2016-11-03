<?php

namespace Melisa\core;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class Input
{
    
    public function __construct() {
        
        logger()->debug(__CLASS__ . ' Class Initialized');
        
    }
    
    public function getDefaultOrigen() {
        
        static $defaultOrigen = NULL;
        
        if( !$defaultOrigen) {
            
            $defaultOrigen = get_instance()
                ->input
                ->is_cli_request() ? 'CLI' : 'POST';
            
        }
        
        return $defaultOrigen;
        
    }
    
    public function groupingInputConfig(&$input, &$rules) {
        
        $defaultOrigen = $this->getDefaultOrigen();
        $fuenteEntrada = [];
        
        /* recorremos los items de entrada requeridos */
        foreach ($input as $field => $type) {
            
            /* normalizamo campo */
            $item = is_numeric($field) ? $type : $field;
            
            /* add rule default */
            if( is_numeric($field)) {
                
                /* set default type  */
                $rules [$item]= [
                    'type'=>$defaultOrigen
                ];
                
            } else {
                
                if( is_array($type)) {
                    
                    $rules [$item]= array_merge([
                        'type'=>$defaultOrigen
                    ], $type);
                    
                } else {
                    
                    /* add rule especificada */
                    $rules [$item]= [
                        'type'=>$type
                    ];
                    
                }
                
            }
            
            /* solo add items unicos */
            if(isset($fuenteEntrada[$rules[$item]['type']][$item])) {
                
                continue;
                
            }
            
            $fuenteEntrada[$rules[$item]['type']][]=$item;
            
        }
        
        return $fuenteEntrada;
        
    }
    
    public function setInputInyect(&$input, &$inputInyect) {
        
        if( is_null($inputInyect)) {
            
            return;
            
        }
        
        if( !is_array($inputInyect)) {

            $inputInyect = [ $inputInyect ];

        }
        
        foreach ($inputInyect as $field => $value) {
            
            $input [$field]= $value;

        }
        
    }
    
    public function init($inputRequired = NULL, $inputInyect = NULL) {
        
        if( is_null($inputRequired)) {
            
            logger()->info('{c}. No input required', [
                'c'=>__CLASS__
            ]);
            return [];
            
        }
        
        if( !is_array($inputRequired)) {
            
            $inputRequired = [ $inputRequired ];
            
        }
        
        $rules = [];
        $input = [];
        $fuenteEntrada = $this->groupingInputConfig($inputRequired, $rules);
        $this->setInputInyect($input, $inputInyect);
        
        if( isset($fuenteEntrada['POST'])) {
            
            if( !$this->getInputOrign(
                    $input,
                    $rules,
                    $fuenteEntrada['POST'])) {
                
                return FALSE;
                
            }
            
        }
        
        if( isset($fuenteEntrada['GET'])) {
            
            if( !$this->getInputOrign(
                    $input,
                    $rules,
                    $fuenteEntrada['GET'],
                    'GET')) {
                
                return FALSE;
                
            }
            
        }
        
        return $input;
        
    }
    
    public function get($inputRequired = NULL, $inputInyect = NULL) {
        
        if( is_null($inputRequired)) {
            
            logger()->info('{c}. No input required', [
                'c'=>__CLASS__
            ]);
            return [];
            
        }
        
        if( !is_array($inputRequired)) {
            
            $inputRequired = [ $inputRequired ];
            
        }
        
        foreach($inputRequired as $i => &$input) {
            
            if(is_numeric($i)) {
                
                $inputRequired [$input]= [
                    'type'=>'GET'
                ];
                
                unset($inputRequired[$i]);
                
            } else {
                
                $inputRequired [$i]= arrayDefault($input, [
                    'type'=>'GET'
                ]);
                
            }
            
        }
        
        return $this->init($inputRequired, $inputInyect);
        
    }
    
    public function getInputOrign(&$input, &$rules, &$inputRequerido, $orign = 'POST') {
        
        static $ci = NULL;
        static $autoDate = NULL;
        
        if( !$ci) {
            
            $ci = get_instance();
            
        }
        
        $flag = TRUE;
        
        foreach($inputRequerido as $field) {
            
            /* inyect ? */
            if( isset($input[$field])) {
                
                /* verify auto input */
                /* esto nos permitira usar rules de logics */
                $result = event()->fire('core.input.inyect_php', [
                    $field,
                    &$input[$field]
                ]);
                
                if( in_array(FALSE, $result)) {
                    
                    $flag = FALSE;
                    break;
                    
                }
                
                continue;
                
            }
            
            $rules [$field]= arrayDefault($rules[$field], [
                'xss'=>TRUE,
                'default'=>NULL,
                'required'=>TRUE
            ]);
            
            if( $orign === 'GET' && isset($_GET[$field])) {
                
                $input [$field]= $ci->abs->input_get($field, $rules[$field]['xss']);
                continue;
                
            }
            
            if( $orign === 'POST' && isset($_POST[$field])) {
                
                $input [$field]= $ci->abs->input_post($field, $rules[$field]['xss']);
                continue;
                
            }
            
            if( is_null($rules[$field]['default']) && $rules[$field]['required']) {
                
                logger()->error('{c}. {o} "{f}" not received, was received {i}', [
                    'c'=>__CLASS__,
                    'o'=>$orign,
                    'f'=>$field,
                    'i'=>var_export($input, TRUE)
                ]);
                
                $flag = FALSE;
                break;
                
            }
            
            if( is_null($rules[$field]['default']) && !$rules[$field]['required']) {
                
                logger()->debug('{c}. Ignored {o} "{f}", field not required', [
                    'c'=>__CLASS__,
                    'f'=>$field,
                    'o'=>$orign
                ]);
                continue;                
                
            }
            
            $input [$field]= $rules[$field]['default'];
            
            $result = event()->fire('core.input.inyect_php', [
                $field,
                &$input[$field]
            ]);
                
            if( in_array(FALSE, $result)) {

                $flag = FALSE;
                break;

            }
            
        }
        
        return $flag;
        
    }
    
}
