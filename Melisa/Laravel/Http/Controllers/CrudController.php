<?php

namespace Melisa\Laravel\Http\Controllers;

use Melisa\Laravel\Http\Controllers\Controller;
use Melisa\Laravel\Logics\PagingLogics;

/**
 * Description of CrudController
 *
 * @author Luis Josafat Heredia Contreras
 */
class CrudController extends Controller
{
    use ClassTrait;
    
    protected $create;
    protected $report;
    protected $update;
    protected $delete;
    protected $paging;
    protected $activate;
    protected $deactivate;
    
    public function getPathCriteria($action)
    {
        $path = $this->getClassNamespace() . '\\Criteria\\';
        if( !is_null($action) && isset($action['criteria'])) {
            return $path . $action['criteria'];
        }
        
        return 'Melisa\Laravel\Criteria\OrderByCriteria';
    }
    
    public function getPathRequest($action)
    {
        $path = $this->getClassNamespace() . '\\Http\Requests\\';
        if( isset($action['request'])) {
            return $path . $action['request'];
        }
        return false;
    }
    
    public function getPathRepositories($action)
    {
        $path = $this->getClassNamespace() . '\\Repositories\\';
        if( !isset($action['repository'])) {
            return $path . $this->getClassEntity() . 'Repository';
        }
        return $path . $action['repository'];
    }
    
    public function getPathLogic($action)
    {
        $path = $this->getClassNamespace() . '\\Logics\\';
        if( !isset($action['logic'])) {
            return false;
        }
        return $path . 
            $this->getClassEntity() . 
            '\\' . 
            $action['logic'];
    }
    
    public function getPathModule($action)
    {
        $path = $this->getClassNamespace() . '\\Modules\\';
        if( !isset($action['module'])) {
            return false;
        }
        return $path . $action['module'];
    }
    
    public function getEventDot()
    {
        return strtolower($this->getClassApp()) . '.' . 
            lcfirst($this->getClassEntity());
    }
    
    public function getEventCreate()
    {
        return $this->getEventDot() . '.create.success';
    }
    
    public function getEventDelete()
    {
        return $this->getEventDot() . '.delete.success';
    }
    
    public function getEventUpdate()
    {
        return $this->getEventDot() . '.update.success';
    }
    
    public function getEventDeactivate()
    {
        return $this->getEventDot() . '.deactivate.success';
    }
    
    public function getEventActivate()
    {
        return $this->getEventDot() . '.activate.success';
    }
    
    public function paging()
    {
        $requestClass = $this->getPathRequest($this->paging);
        if( !$requestClass) {
            $requestClass = 'Melisa\Laravel\Http\Requests\PagingRequest';
        }
        $request = app($requestClass);
        $repository = app($this->getPathRepositories($this->paging));
        $criteria = app($this->getPathCriteria($this->paging));
        
        if( isset($this->paging['fieldOrder'])) {
            $criteria->setFieldOrder($this->paging['fieldOrder']);
        }
        
        $logic = new PagingLogics($repository, $criteria);
        return $logic->init($request->allValid());        
    }
    
    public function createUpdate($requestDefault, $logicDefault, $event)
    {
        $requestClass = $this->getPathRequest($this->create);
        if( !$requestClass) {
            $requestClass = $this->getClassNamespace() . 
                '\\Http\\Requests\\' . 
                $this->getClassEntity() . 
                '\\' . $requestDefault;
        } 
        $request = app($requestClass);
        $repository = app($this->getPathRepositories($this->create));
        $logicClass = $this->getPathLogic($this->create);
        if( !$logicClass) {
            $logicClass = 'Melisa\Laravel\Logics\\' . $logicDefault;
            $logic = new $logicClass($repository);
            if( !isset($this->create['event'])) {
                $logic->setFireEvent($event);
            } else {
                $logic->setFireEvent($this->create['event']);
            }
        } else {
            $logic = app($logicClass);
        }
        
        $result = $logic->init($request->allValid());        
        return response()->data($result);
    }
    
    public function create()
    {        
        $requestClass = $this->getPathRequest($this->create);
        if( !$requestClass) {
            $requestClass = $this->getClassNamespace() . 
                '\\Http\\Requests\\' . 
                $this->getClassEntity() . 
                '\\CreateRequest';
        } 
        $request = app($requestClass);
        $repository = app($this->getPathRepositories($this->create));
        $logicClass = $this->getPathLogic($this->create);
        if( !$logicClass) {
            $logicClass = 'Melisa\Laravel\Logics\\CreateLogic';
            $logic = new $logicClass($repository);
            if( !isset($this->create['event'])) {
                $logic->setFireEvent($this->getEventCreate());
            } else {
                $logic->setFireEvent($this->create['event']);
            }
        } else {
            $logic = app($logicClass);
        }
        
        $result = $logic->init($request->allValid());        
        return response()->data($result); 
    }
    
    public function update()
    {
        $requestClass = $this->getPathRequest($this->update);
        if( !$requestClass) {
            $requestClass = $this->getClassNamespace() . 
                '\\Http\\Requests\\' . 
                $this->getClassEntity() . 
                '\\UpdateRequest';
        } 
        $request = app($requestClass);
        $repository = app($this->getPathRepositories($this->update));
        $logicClass = $this->getPathLogic($this->update);
        if( !$logicClass) {
            $logicClass = 'Melisa\Laravel\Logics\\UpdateLogic';
            $logic = new $logicClass($repository);
            if( !isset($this->update['event'])) {
                $logic->setFireEvent($this->getEventUpdate());
            } else {
                $logic->setFireEvent($this->update['event']);
            }
        } else {
            $logic = app($logicClass);
        }
        
        $result = $logic->init($request->allValid());        
        return response()->data($result);       
    }
    
    public function activate()
    {
        $requestClass = $this->getPathRequest($this->activate);
        if( !$requestClass) {
            $requestClass = 'Melisa\Laravel\Http\Requests\ActivateDeactivateRequest';
        }
        
        $request = app($requestClass);
        $repository = app($this->getPathRepositories($this->activate));
        $logicClass = $this->getPathLogic($this->activate);
        if( !$logicClass) {
            $logicClass = 'Melisa\Laravel\Logics\\ActivateLogic';
        }
        $logic = new $logicClass($repository);
        
        if( !isset($this->activate['event'])) {
            $logic->setFireEvent($this->getEventActivate());
        } else {
            $logic->setFireEvent($this->activate['event']);
        }
        
        $result = $logic->init($request->allValid());        
        return response()->data($result);
    }
    
    public function deactivate()
    {
        $requestClass = $this->getPathRequest($this->deactivate);
        if( !$requestClass) {
            $requestClass = 'Melisa\Laravel\Http\Requests\ActivateDeactivateRequest';
        }
        
        $request = app($requestClass);
        $repository = app($this->getPathRepositories($this->deactivate));
        $logicClass = $this->getPathLogic($this->deactivate);
        if( !$logicClass) {
            $logicClass = 'Melisa\Laravel\Logics\\DeactivateLogic';
        }
        $logic = new $logicClass($repository);
        
        if( !isset($this->activate['event'])) {
            $logic->setFireEvent($this->getEventDeactivate());
        } else {
            $logic->setFireEvent($this->deactivate['event']);
        }
        
        $result = $logic->init($request->allValid());        
        return response()->data($result);
    }
    
    public function report($id, $format = 'json')
    {
        $logicClass = $this->getPathLogic($this->report);
        if( !$logicClass) {
            $logicClass = 'Melisa\Laravel\Logics\ReportLogic';
        }
        
        $repository = app($this->getPathRepositories($this->report));
        $logic = new $logicClass($repository);        
        $result = $logic->init($id);
        
        if( $format === 'json') {
            return response()->data($result);
        }
        
        $moduleClass = $this->getPathModule($this->report);
        if( !$moduleClass) {
            melisa('logger')->error('No module class configuration');
            return response()->data(false);
        }
        return app($moduleClass)
            ->withInput($result)
            ->render($id);
    }
    
    public function delete()
    {
        $requestClass = $this->getPathRequest($this->delete);
        if( !$requestClass) {
            $requestClass = 'Melisa\Laravel\Http\Requests\ActivateDeactivateRequest';
        }
        
        $request = app($requestClass);
        $logicClass = $this->getPathLogic($this->delete);
        if( !$logicClass) {
            $logicClass = 'Melisa\Laravel\Logics\DeleteLogic';
        }
        $repository = app($this->getPathRepositories($this->delete));
        $logic = new $logicClass($repository);
        
        if( !isset($this->delete['event'])) {
            $logic->setFireEvent($this->getEventDelete());
        } else {
            $logic->setFireEvent($this->delete['event']);
        }
        
        $result = $logic->init($request->allValid());
        return response()->data($result);
    }
    
}
