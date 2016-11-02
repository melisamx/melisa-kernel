<?php 

if( !function_exists('array_is_multi_array')) {
    
    function array_is_multi_array($arr) {
        rsort( $arr );
        return isset( $arr[0] ) && is_array( $arr[0] );
    }
    
}

if( !function_exists('array_default')) {
    
    function array_default(&$arregloBase, $arrayDefault) {

        foreach($arrayDefault as $key => $valor) {

            if (isset($arregloBase[$key])) {

                $arrayDefault[$key] = $arregloBase[$key];
                unset($arregloBase[$key]);

            } else {
                
                $arrayDefault = array_merge($arregloBase, $arrayDefault);
                
            }

        }

        return $arrayDefault;

    }
    
}

if( !function_exists('array_interpolate'))
{
    
    function array_interpolate($template, array $context = array()) {
        
        /* build a replacement array with braces around the context keys */
        $keysReplace = array();
        foreach($context as $key => $val) {
            
            // check that the value can be casted to string
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                
                $keysReplace['{'.$key.'}'] = $val;
                
            }            
            
        }
        
        /* interpolate replacement values into the message and return */
        return strtr($template, $keysReplace);        
        
    }
    
}

if( !function_exists('arrayIndexOfExist')) {
    
    function arrayIndexOfExist($needle, $haystack) {
        
        foreach ($haystack as $item) {
            
           if (strpos($item, $needle) !== FALSE) {
              return TRUE;
              break;
           }
           
        }
        
        return FALSE;
        
    }
    
}
