<?php

namespace Melisa\Laravel\Http\Controllers;

/**
 * Description of ClassTrait
 *
 * @author Luis Josafat Heredia Contreras
 */
trait ClassTrait
{    
    
    public function getClassNamespace()
    {   
        return implode('\\', array_slice(
            explode('\\', get_called_class()),
            0, 2));
    }
    
    public function getClassApp()
    {   
        return implode('\\', array_slice(
            explode('\\', get_called_class()), 
            1, 1));
    }
    
    public function getClassEntity()
    {
        return str_replace('Controller', '', array_slice(
            explode('\\', get_called_class()), 
            -1)[0]);
    }
    
}
