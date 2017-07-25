<?php

namespace Melisa\Laravel\Http\Controllers;

use Melisa\Laravel\Http\Controllers\Controller;

/**
 * Module patron controller
 *
 * @author Luis Josafat Heredia Contreras
 */
class ModuleController extends Controller
{
    use ClassTrait;
    
    protected $view = [];

    public function getPathModules($action, $type = 'Desktop')
    {
        $path = $this->getClassNamespace() . '\\Modules\\';
        if( !isset($action['module'])) {
            return $path . 
                $type . '\\' .
                $this->getClassEntity('Modules') . 
                '\\';
        }
        return $path . $action['module'];
    }
    
    public function add()
    {
        $modulePath = $this->getPathModules($this->view) . 'AddModule';
        $moduleClass = app($modulePath);
        return $moduleClass->render();
    }
    
    public function view()
    {
        $modulePath = $this->getPathModules($this->view) . 'ViewModule';
        $moduleClass = app($modulePath);
        return $moduleClass->render();
    }
    
    public function update()
    {
        $modulePath = $this->getPathModules($this->view) . 'UpdateModule';
        $moduleClass = app($modulePath);
        return $moduleClass->render();
    }
    
}
