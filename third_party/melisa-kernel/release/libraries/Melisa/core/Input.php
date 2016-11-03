<?php

namespace Melisa\core;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class Input extends Base
{
    
    public function __construct() {
        
        logger()->debug(__CLASS__.' Class Initialized');
        
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
                
                /* verify type array */
                if( is_array($type)) {
                    
                    /* add url default  */
                    $rules [$item]= array_default($type, [
                        'type'=>$defaultOrigen
                    ]);
                    
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
    
    public function get($inputRequired = NULL, $inputInyect = NULL) {
        
        if( is_null($inputRequired)) {
            
            return TRUE;
            
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
    public function getInputOrign(&$input, &$rules, &$inputRequerido, $orign = 'POST') {
        
        static $ci = NULL;
        static $autoDate = NULL;
        
        if( !$ci) {
            
            $ci = get_instance();
            $autoDate = date('Y-m-d H:i:s');
            
        }
        
        $flag = TRUE;
        
        foreach($inputRequerido as $field) {
            
            /* inyect ? */
            if( isset($input[$field])) {
                
                /* verify auto input */
                /* esto nos permitira usar rules de logics */
                $result = $this->event()->fire('core.input.inyect_php', [
                    $field,
                    &$input[$field]
                ]);
                
                if( in_array(FALSE, $result)) {
                    
                    $flag = FALSE;
                    break;
                    
                }
                
                continue;
                
            }
            
            $rules [$field]= array_default($rules[$field], [
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
            
            if( $rules[$field]['default'] === 'CURRENT_TIMESTAMP' ) {
                
                $input[$field] = $autoDate;
                
            } else {
                
                $input[$field] = $rules[$field]['default'];
                
            }
            
        }
        
        return $flag;
        
    }
    
}
