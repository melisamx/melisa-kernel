<?php

namespace Melisa;
use Melisa\application\validations\Base as ValidationBase;
use Melisa\application\validations\BeforeAction as ValidationBeforeAction;

class Application
{
    
    private $okInit = TRUE;
    private $configDefault;    
    public $db = '';
    public $app = '';
    public $ambito;
    public $session;
    public $sessionId;
    public $securityType;
    
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
        
    }
    
    public function init($config = []) {
        
        $ci = &get_instance();
        
        $ci->load->library('Melisa/ci/Base', NULL, 'abs');
        
        /**
         * 
         * load helpers, todas las clases de logicas la usan, esto les permite 
         * cambiar su comportamiento inyectando parametros en la funcion init
         * 
         */
        $ci->abs->load_helper([
            'arrays',
            'message',
            'nodejs',
            'loader',
            'events'
        ]);
        
        /**
         * 
         * combinamos parametros default con los nuevos
         * 
         */
        
        $this->configDefault = array_default($config, $this->configDefault);
        
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
        
        $config = array_default($config, $this->configDefault);
        
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
    
    public function load() {
        
        return loader(__NAMESPACE__ . '\core\Loader', 'libraries', $this);
        
    }
    
    public function afterAction() {
        
        return TRUE;
        
    }
    
    public function output() {
        
        return $this->load()->libraries(__NAMESPACE__ . '\core\Output');
        
    }
    
}

