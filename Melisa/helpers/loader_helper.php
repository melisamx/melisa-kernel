<?php 

if( !function_exists('loaderSearchFile')) {
    
    function loaderSearchFile($className, $classPath = '', $autoInclude = TRUE, $fileExtension = '.php') {
        
        static $paths = [];
        
        if( empty($paths)) {
            
            $paths = get_instance()->app->getPaths();
            
        }
        
        $bandera = FALSE;
        $pathLocation = '';
        
        /* recorremos los paths permitidos en donde buscar */
        foreach ($paths as $path) {
            
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
        
        $classInstance = $className;
        
        // suport class namespaces
        if( strpos($className, '/')) {
            
            $classInstance = str_replace('/', '\\', $className);            
            $ns = explode('/', $className);            
            $className = array_pop($ns);            
            $classPath = implode('/', $ns);
            
        }
        
        if( isset($loadedClass[$classInstance])) {
            
            return $loadedClass[$classInstance];
            
        }
        
        if(class_exists($classInstance, FALSE)) {
            
            $loadedClass[$classInstance] = new $classInstance();

            return $loadedClass[$classInstance];
            
        }
        
        $pathExistClass = loaderSearchFile(str_replace('\\', '/', $className), $classPath);
        
        if( !$pathExistClass || !class_exists($classInstance)) {
            
            msg()->add([
                'type'=>'warning',
                'file'=>__FILE__,
                'line'=>__LINE__,
                'message'=>'Class no exist ' . (
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
            new $classInstance() : new $classInstance($params);

        
        return $loadedClass[$className];
        
    }
    
}
