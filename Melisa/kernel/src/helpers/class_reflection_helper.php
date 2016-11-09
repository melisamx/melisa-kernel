<?php 

if( !function_exists('class_list_public')) {
    
    function class_list_public($varlPhpClass) {
        
        static $varlPhpReflections=array();
        
        /* get name class */
        $varlPhpClass_name=get_class($varlPhpClass);
        
        /* verify second reflection */
        if( isset($varlPhpReflections[$varlPhpClass_name])) 
            return $varlPhpReflections[$varlPhpClass_name];
        
        /* create reflection object */
        $varlPhpRefle=new ReflectionObject($varlPhpClass);
        
        /* recorremos metodos */
        foreach ($varlPhpRefle->getMethods() as $varlPhpMetodo) {
            
            if( !$varlPhpMetodo->isPublic() || 
                    in_array(
                            $varlPhpMetodo->getName(),array(
                                '__construct',
                                'get_instance',
                                'index'
                                )
                    )) continue;
            
            /* get documentacion */
            $varlPhpDoc=$varlPhpMetodo->getDocComment();
            
            /* verify */
            if( !$varlPhpDoc) $varlPhpReflections[$varlPhpClass_name][]=$varlPhpMetodo->getName();
            
            /* limpiamos documentacion */
            $varlPhpDoc=str_replace(array(
                '*',
                '/',
                '\\',
                PHP_EOL,
                '\t',
            ), '', $varlPhpDoc);
            
            $varlPhpReflections[$varlPhpClass_name][]=$varlPhpMetodo->getName().
                    ' -> '.
                    trim($varlPhpDoc);
        }
        
        return $varlPhpReflections[$varlPhpClass_name];

    }
    
}