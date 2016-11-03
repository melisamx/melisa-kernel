<?php 

if( !function_exists('loaderSearchFile')) {
    
    function loaderSearchFile($className, $classPath = '', $autoInclude = TRUE, $fileExtension = '.php') {
        
        $bandera = FALSE;
        $pathLocation = '';
        
        /* recorremos los paths permitidos en donde buscar */
        foreach ([APPPATH, MYAPPCORE, MYCORE] as $path) {
            
            /* verify file */
            if( !file_exists($path.$classPath.'/'.$className.$fileExtension)) {
                
                continue;
                
            }
            
            /* verify auto include  */
            if($autoInclude) {

                /* incluimos el archivo */
                include $path.$classPath.'/'.$className.$fileExtension;

            }
            
            $bandera = TRUE;
            $pathLocation = $path.$classPath.'/';
            break;
            
        }
        
        if($bandera) {
            
            return $pathLocation;
            
        }
        
        return FALSE;
        
    }
    
}

if( !function_exists('loader')) {
    
    function &loader($className, $classPath = '', $params = NULL) {
        
        static $loadedClass = [];
        
        // suport class namespaces
        if( strpos($className, '/')) {
            
            $className = str_replace('/', '\\', $className);
            
        }
        
        if( isset($loadedClass[$className])) {
            
            return $loadedClass[$className];
            
        }
        
        if(class_exists($className, FALSE)) {
            
            $loadedClass[$className] = new $className();

            return $loadedClass[$className];
            
        }
        
        $pathExistClass = loaderSearchFile(str_replace('\\', '/', $className), $classPath);
        
        if( !$pathExistClass || !class_exists($className)) {
            
            /* registramos el error */
            msg()->add([
                'type'=>'warning',
                'file'=>__FILE__,
                'line'=>__LINE__,
                'msg'=>'Class no exist ' . (
                    ENVIRONMENT != 'development' ? 
                    '' : 
                    ':'. $classPath.'/'.$className
                )
            ]);
            
            $messages = msg()->get();
            
            /* terminamos app */
            exit(json_encode(arrayDefault($messages, [
                'success'=>FALSE
            ])));
            
        }
        
        if(MYDEBUG) {
            
            log_message('debug', 'Load class ' . $pathExistClass . $className);

        }
        
        $loadedClass[$className] = is_null($params) ? 
            new $className() : new $className($params);

        
        return $loadedClass[$className];
        
    }
    
}
