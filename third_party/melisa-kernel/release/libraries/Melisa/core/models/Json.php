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
        exit(var_dump($pathModel));
    }
    
}
