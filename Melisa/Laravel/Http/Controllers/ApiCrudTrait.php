<?php

namespace Melisa\Laravel\Http\Controllers;

/**
 * Support api namespaces
 *
 * @author Luis Josafat Heredia Contreras
 */
trait ApiCrudTrait
{

    public function getClassEntity($type = 'Controllers')
    {
        $segments = explode('\\', get_called_class());
        $base = array_slice(array_slice($segments, array_search($type, $segments) + 1), 2);
        $index = array_search($segments[count($segments) - 1], $base);
        $base[$index] = str_replace('Controller', '', $base[$index]);
        return implode('\\', $base);
    }
    
}
