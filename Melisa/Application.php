<?php

namespace Melisa;

use Melisa\application\validations\Base as ValidationBase;
use Melisa\application\validations\BeforeAction as ValidationBeforeAction;
use Melisa\codeigniter\Base as AbstractCodeigniter;
use Optimus\Onion\Onion as Middleware;
use Optimus\Onion\LayerInterface;
use Closure;

class BeforeLayer implements LayerInterface {

    public function peel($object, Closure $next)
    {
        $object->runs[] = 'before';

        return $next($object);
    }

}

class AfterLayer implements LayerInterface {

    public function peel($object, Closure $next)
    {
        $response = $next($object);
        
        $object->runs[] = 'after';

        return $response;
    }

}

class Application
{
    
    private $okInit = TRUE;
    private $configDefault;    
    public $db = '';
    public $app = '';
    public $session;
    public $sessionId;
    public $securityType;
    public $paths = [
        MYINSTALLROOT,
        APPPATH,
        MYAPPCORE,
        MYCORE
    ];
    
    public function __construct() {
        
        log_message('debug', __CLASS__ . ' Class Initialized');
        
        /**
         * set config default, este nos permitira poder definir parametros a 
         * nivel de clase y no solo por funcion de controlador
         * 
         */        
        $this->configDefault = [
            'autentificacion.requerida'=>TRUE,
            'autentificacion.type'=>'default',
            'autentificacion.alternate.httpBasic'=>TRUE,
            'handler'=>__CLASS__,
            'output.type'=>'json',
            'request.force_ajax'=>TRUE,
            'request.only_local'=>FALSE,
            'request.only_cli'=>FALSE,
            'request.installApp'=>FALSE,
            'jwt.require'=>FALSE,
            'continue.logic'=>TRUE,
            'conexion'=>$this->db
        ];
        
        $this->middleware = new Middleware();
        
        $object = new \StdClass;
        $object->runs = [];
        
        $end =  $this->middleware->layer([
                new AfterLayer(),
                new BeforeLayer(),
                new AfterLayer(),
                new BeforeLayer(),
                new BeforeLayer()
            ])
            ->peel($object, function($object){
//                exit(var_dump($object));
                $object->runs[] = 'core';
                return $object;
            });

var_dump($end);
        
    }
    
    public function getPaths() {
        
        return $this->paths;
        
    }
    
    public function init($config = []) {
        
        $ci = &get_instance();
        
        $ci->abs = new AbstractCodeigniter();
        
        /**
         * 
         * load helpers, todas las clases de logicas la usan, esto les permite 
         * cambiar su comportamiento inyectando parametros en la funcion init
         * 
         */
        $ci->abs->load_helper([
            'arrays',
            'loader',
            'services',
            'strings'
        ]);
        
        /**
         * 
         * combinamos parametros default con los nuevos
         * 
         */
        
        $this->configDefault = arrayDefault($config, $this->configDefault);
        
        if( !$this->isValidInit($this->configDefault)) {
            
            return $this->okInit = FALSE;
            
        }
        
        return TRUE;
        
    }
    
    public function beforeAction($config = []) {
        
        /**
         *
         * Combinamos config personalizado con opciones default, 
         * esto nos permitira cambiar parametros necesarios para 
         * producir respuestas validas segun el tipo de respuesta esperada por 
         * cada funcion del controlador
         *  
         */
        
        $config = arrayDefault($config, $this->configDefault);
        
        if ($config['request.only_cli']) {
            
            return FALSE;
            
        }
        
        if( !$this->okInit) {
            
            return $this->showErrorAppInit($config);
            
        }
        
        if( !$this->isValidBeforeAction($config)) {
            
            return FALSE;
            
        }
        
        return TRUE;
        
    }
    
    public function isValidBeforeAction(&$config = []) {
        
        $validations = new ValidationBeforeAction($this);
        
        if( !$validations->init($config)) {
            
            return FALSE;
            
        }
        
        return TRUE;
        
    }
    
    public function isValidInit(&$config = []) {
        
        $validations = new ValidationBase($this);
        
        if( !$validations->init($config)) {
            
            return FALSE;
            
        }
        
        return TRUE;
        
    }
    
    public function afterAction() {
        
        return TRUE;
        
    }
    
}

