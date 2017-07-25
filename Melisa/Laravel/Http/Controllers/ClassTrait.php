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
    
    public function getClassEntity($type = 'Controllers')
    {
        $segments = explode('\\', get_called_class());
        $base = array_slice($segments, array_search($type, $segments) + 1);
        $index = array_search($segments[count($segments) - 1], $base);
        $base[$index] = str_replace('Controller', '', $base[$index]);
        return implode('\\', $base);
    }
    
}
