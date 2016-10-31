<?php 

namespace Melisa\ci;

/**
 * Clase base que abstrae el uso directo del framework Codeigniter
 * @version 1.1
 * @author Luis Josafat Heredia Contreras
 */
class Base
{
    
    private $ci;
    
    public function __construct() {
        
        $this->ci = &get_instance();
        
        /* create defines */
        define('MYDEBUG', ENVIRONMENT == 'development' ? TRUE : FALSE);
        
    }
    
    public function uri_segment($segment) {
        
        return $this->ci->uri->segment($segment);
        
    }
    
    public function library_error_ok() {
        
        /* verificamos si existe la libreria error */
        if( !isset($this->ci->liphperror)) {
            
            return TRUE;
            
        }
        
        /* retornamos si hay realmente errores */
        return $this->ci->liphperror->fnpPhpOk();        
        
    }
    
    public function security_xss_clean($item) {
        
        return $this->ci->security->xss_clean($item);
        
    }
    
    public function user_agent_get() {
        
        /* inicializamos con user agent desconocido */
        $userAgent = array(
            'tipo'=>'desconocido',
            'nombre'=>'',
            'version'=>0,
            'plataforma'=>'',
            'referrer'=>''            
        );
        
        /* cargamos la libreria para verificar el tipo de user agent */
        $this->library_is_load('user_agent');
        
        if($this->ci->agent->is_mobile()) {
            
            /* por elmomento solo para reusar la app en ambiente mobile */
            $userAgent['tipo'] = 'mobile';
            $userAgent['nombre'] = $this->ci->agent->mobile();
            $userAgent['plataforma'] = $this->ci->agent->platform();
            
        } elseif($this->ci->agent->is_robot()) {

            $userAgent['tipo']='robot';
            $userAgent['nombre']=$this->ci->agent->robot();

        } elseif($this->ci->agent->is_browser()) {
            
            $userAgent['tipo']='browser';
            $userAgent['nombre']=$this->ci->agent->browser();
            $userAgent['version']=$this->ci->agent->version();
            $userAgent['plataforma']=$this->ci->agent->platform();
            
        } elseif($this->ci->input->is_cli_request()) {
            
            $userAgent['tipo']='cli';
            
        }
        
        /* verificamos si el agente procede desde otro lugar */
        if($this->ci->agent->is_referral()) {

            $userAgent['referrer']=$this->ci->agent->referrer();

        }

        return $userAgent;
        
    }
    
    /**
     * Carga libreria si es que no se ha cargado con anterioridad
     * @param string $library 
     */
    public function library_is_load($library, $path = '') {
        
        if($this->ci->load->is_loaded(strtolower($library)) == FALSE) {
            
            $this->load_library($path . $library);
            
        }
        
    }
    
    /**
     * Carga una libreria
     * @param type $library Nombre de la libreria
     */
    public function load_library($library, $extraParams = NULL, $name = NULL) {
        
        $this->ci->load->library($library, $extraParams, $name);
        
    }
    
    /**
     * Carga o retorna el contenido de un archivo de lenguaje en especifico, 
     * por default obtendra el contenido del lenguaje establecido en el config 
     * global
     * 
     * @param type $fileLang Nombre del archivo de lenguaje a cargar
     * @param String $item Obtiene los item de un lenguaje en 
     * especifico
     * @param type $retornar Retorna en un array los item del lenguaje a 
     * cargar
     * @return mixed Obtiene los valores del lenguaje si se estable TRUe en el 
     * tercer parametro
     */
    public function load_lang($fileLang, $item = '', $retornar = TRUE, $sufijo = FALSE) {
        
        if($retornar) {
            
            return $this->ci->lang->load($fileLang, $item, $retornar, $sufijo);
            
        }
        
        $this->ci->lang->load($fileLang, $item, $retornar, $sufijo);
        
    }
    
    /**
     * Carga un driver
     * @param type $driverName Nombre del driver a cargar
     */
    public function load_driver($driverName, $params = NULL) {
        
        $this->ci->load->driver($driverName, $params);
        
    }
    
    /**
     * Cargar driver database
     * @param mixed $grupoName Parametros de configuracion o DSN
     * @return integer ID conexion
     */
    public function load_database($grupoName = '', $return = FALSE, $activeRecord = NULL) {
        
        return $this->ci->load->database($grupoName, $return, $activeRecord);
        
    }
    
    public function log($message, $type = 'debug') {
        
        $logMessage = implode(PHP_EOL, (!is_array($message ) ? array($message) : $message));
        
        if($this->env_get()) {
            
            
            log_message($type, $logMessage);
            
        } else {
            
            if($type=='error') {
                
                log_message($type, $logMessage);
                
            }
            
        }
        
    }
    
    public function env_get() {
        
        return (ENVIRONMENT == 'development' ? TRUE : FALSE);
        
    }
    
    /**
     * Carga driver si es que no se ha cargado con anterioridad
     * @param string $driver 
     */
    public function driver_is_load($driver = 'cache') {
        
        if( !isset($this->ci->{$driver})) {
            
            /* load driver */
            $this->load_driver($driver, array(
                'adapter'=>'memcached',
                'backup'=>'apc'));
            
            /*$this->load_driver($varlPhpDriver,array(
                'adapter'=>'apc',
                'backup'=>'file'));*/
            
        }
        
        return $this;
        
    }
    
    /**
     * Obtiene un item del archivo de configuración
     * 
     * @param type $item Nombre del item
     * @return void valore del item
     */
    public function config_get($item, $seccion = '') {
        
        return $this->ci->config->item($item, $seccion);
        
    }
    
    /**
     * Obtiene o imprimie un item de la configuración global
     * 
     * @param String $item Nombre del item de configuración global
     * @param Boolean $echo Imprimir el valor usando echo
     * @return type Retorna los valores del item global si es que se especifica
     * TRUE en el segundo parametro
     */
    public function config_global_get($item, $echo = FALSE) {
        
        if( !$echo) {
            
            return $this->ci->config->config[$item];
            
        }
        
        echo $this->ci->config->config[$item];
        
    }
    
    /**
     * Estable el valor de un item de configuración
     * 
     * @param type $item Nombre del item
     * @param type $value Valor
     */
    public function config_set($item, $value = NULL) {
        
        /* verify */
        if(is_array($item)) {
            
            foreach ($item as $key => $val) {
                
                $this->config_set($key, $val);
                
            }
            
            /* chain */
            return $this;
        }
        
        /* set item */
        $this->ci->config->set_item($item, $value);
        
        /* chain */
        return $this;
        
    }
    
    /**
     * Carga un archivo de configuración
     * 
     * @param type $fileConfig Nombre del archivo config
     * @return boleano TRUE/FALSE
     */
    public function load_config($fileConfig, $seccion = FALSE, $silent = FALSE) {
        
        if($silent) {
            
            return $this->ci->config->load($fileConfig, $seccion, $silent);
            
        }
        
        $this->ci->config->load($fileConfig, $seccion);
        
        /* metodo chaining */
        return $this;
        
    }
    
    /**
     * Estable un especifico encabezado de salida
     * 
     * @param String $header Encabezado
     */
    public function output_set_header($header) {
        
        $this->ci->output->set_header($header);
        
        return $this;
        
    }
    
    /**
     * Estable datos en el buffer de salida
     * 
     * @param String $output Datos de salida
     */
    public function output_set($output) {
        
        $this->ci->output->set_output($output);
    }
    
    /**
     * Estable un tipo de encabezado predefinido (js,json,css), js por default
     * 
     * @param String $type Tipo de encabezado a establecer
     */
    public function output_set_content_type($type = 'js') {
        
        switch ($type) {
            
            case 'json':
                $this->ci->output->set_content_type('json');
                break;
            case 'css':
                $this->ci->output->set_content_type('css');
                break;
            case 'html':
                $this->ci->output->set_content_type('html');
                break;
            case 'pdf':
                $this->ci->output->set_content_type('application/pdf');
                break;
            default:
                $this->ci->output->set_content_type('js');
                break;
        }
        
        return $this;
        
    }
    
    public function output_append($output) {
        
        $this->ci->output->append_output($output);
        return $this;
        
    }
    
    /**
     * Obtiene el actual estado del buffer de salidad
     * 
     * @return type String
     */
    public function output_get() {
        
        return $this->ci->output->get_output();
        
    }
    
    /**
     * Obtiene el valor de un item de sesión
     * 
     * @param type $item
     * @return mixed Valor del item de sesión 
     */
    public function session_get($item) {
        
        return $this->ci->session->userdata($item);
        
    }
    
    public function session_unset($item) {
        
        $this->ci->session->unset_userdata($item);
        
    }
    
    public function session_all_userdata() {
        
        return $this->ci->session->all_userdata();
        
    }
    
    /**
     * Establece el valor a un item de sesión
     * 
     * @param type $varlPhpPar Nombre del item
     * @param type $value Valor
     */
    public function session_set($item, $value) {
        
        $this->ci->session->set_userdata($item, $value);
        return $this;
        
    }
    
    /**
     * Almacena en cache la salida por numero determinado de minutos
     * @param type $time Minutos que durara la cache
     */
    public function output_cache($time = 480) {
        
        $this->ci->output->cache($time);
        
    }
    
    public function cache_file_get($item, $path = '') {
        
        return $this->ci->cache->file->get($item,$path);
        
    }
    
    public function cache_get($item, $path = '') {
        
        /* fix bug memcached no permite espacios  */
        $item = preg_replace('/[^A-Za-z0-9\.\_]/', '', str_replace(' ', '_', $item));
        
        return $this->ci->cache->get(MYAPPID . '.' . $item, $path);
        
    }
    
    public function cache_delete($key = '', $multi = FALSE) {
        
        if( !$multi) {
            
            $key = preg_replace('/[^A-Za-z0-9\.\_]/', '', str_replace(' ', '_', $key));
            
            return $this->ci->cache->delete(MYAPPID . '.' . $key);
            
        }
        
        $key = str_replace(' ', '_', $key);
        
        /* get cache info user */
        $cache = $this->cache_info('user');
        $keyDefault = 'info';
        
        /* recorremos la lista de elementos en cache */
        foreach($cache['cache_list'] as $item) {
            
            /* parche para que funcion en apcu  */
            if( !isset($item[$keyDefault])) {
                
                $keyDefault = 'key';
            }
            
            /* verify si coincide el item */
            if(preg_match($key, $item[$keyDefault]) == 0) {
                
                continue;
                
            }
            
            /* eliminamos el item */
            $this->ci->cache->delete($item[$keyDefault]);

        }
        
        return TRUE;
        
    }
    
    public function cache_clean() {
        
        return $this->ci->cache->clean();
        
    }
    
    public function cache_info($type = 'user') {
        
        return $this->ci->cache->cache_info($type);
        
    }
    
    public function cache_file_delete($item) {
        
        return $this->ci->cache->file->delete(MYAPPID . MYCACHESEPARADOR . $item);
        
    }
    
    /**
     * Carga una vista basandose en el user agent
     * @param type $view Nombre de la vista a cargar
     * @param type $params Parametros adicionales
     */
    public function load_view($view, $params = array(), $return = FALSE) {
        
        if($return) {
            
            return $this->ci->load->view($view, $params, $return);
            
        }
        
        $this->ci->load->view($view,$params,$return);
        
    }
    
    public function load_file($file, $return = TRUE) {
        
        if($return) {
            
            return $this->ci->load->file($file, TRUE);
            
        }
        
        $this->ci->load->file($file, $return);
        
    }
    
    /**
     * Elimina las etiquetas script y style usadas en las vistas
     *
     * @param type $type Tipo de etiquetas que se eliminaran
     */
    public function output_sin_etiquetas($type = 'js') {
        
        if($type == 'js') {
            
            $this->output_set(
                    trim(str_replace(
                            array(
                                '<script '.'type="text/javascript">',
                                '</script>'),
                            '',
                            $this->output_get())));
            
        } elseif($type=='css') {
            
            $this->output_set(
                    trim(str_replace(
                            array(
                                '<style '.'type="text/css">',
                                '</style>'),
                            '',
                            $this->output_get())));
            
        }
        
        return $this;
        
    }
    
    public function cache_file_save($item, $value, $time = -1, $path = '') {
        
        if($time == -1) {
            
            return $this->ci->cache->file->save(
                    $item,
                    $value,
                    2678400,
                    $path);
            
        }
        
        return $this->ci->cache->file->save($item, $value, $time, $path);
        
    }
    
    public function cache_save($item, $value, $time = -1) {
        
        $item = preg_replace('/[^A-Za-z0-9\.\_]/', '', str_replace(' ', '_', $item));
        
        if($time == -1) {
            
            return $this->ci->cache->save(
                    MYAPPID.MYCACHESEPARADOR.$item,
                    $value,
                    0);
            
            /*
             * en memcache si se establece un valor mayor a 90*90*24*30
             * se almacena el item pero se elimina al mismo tiempo
             * es mejor establecer cero ya que en apc como en memcache jamas 
             * expira el item a menos ke se reinicie el servidor
             * 
             */
            
        }
        
        return $this->ci->cache->save(MYAPPID . MYCACHESEPARADOR . $item, $value, $time);
        
    }
    
    public function router_get_metodo() {
        
        return $this->ci->router->fetch_method();
        
    }
    
    /**
     * Establece enzabezados de expiración, tipo mime y elimina etiquetas 
     * adicionales usadas en la programación (style, script)
     * 
     * @param String $type Tipo mime
     */
    public function header_set_expire($type = 'js') {
        
        /* establecemos el tipo de recurso */
        $this->output_set_content_type($type)        
        /* establecemos encabezados para usar la cache del navegador */
                ->output_set_header('Pragma:')
                ->output_set_header(
                'Expires: '.gmdate('D, d M Y H:i:s',
                        time()+2678400).' GMT')
                ->output_set_header('Cache-Control: must-revalidate')
        /* eliminamos etiquetas de mas */
                ->output_sin_etiquetas($type);
        
    }
    
    public function input_get_request_header($item, $xss = TRUE) {
        
        return $this->ci->input->get_request_header($item, $xss);
        
    }
    
    public function header_set_php($header) {
        
        header($header);
        
    }
    
    function crear_script_config($data, $return = TRUE) {
        
        /* establecemos parametros */
        $varlPhpFuncion = json_encode($data);
        
        /* get view */
        $html = $this->load_view('partials/loader_privado.js', array(), TRUE);
        
        $html = str_replace('"{{funcion}}"', $varlPhpFuncion, $html);
        
        /* verify return */
        if($return==TRUE) {
            
            return $html;
            
        }
        
        echo $html;
        
    }
    
    public function benchmark_elapsed() {
        
        return $this->ci->benchmark->memory_usage();
        
    }
    
    public function benchmark_memory() {
        
        return $this->ci->benchmark->memory_usage();
        
    }
    
    public function security_csrf_ok() {
        
        return $this->ci->security->verificar_csrf();
        
    }
    
    public function security_csrf_error_get() {
        
        return $this->ci->security->csrf_error_get();
        
    }
    
    public function security_get_csrf_hash() {
        
        return $this->ci->security->get_csrf_hash();
        
    }
    
    /**
     * Obitiene un parametro tipo POST
     * 
     * @param type $item Nombre del parametro a obtener
     * @param Boolean $xss Aplica filtros XSS
     * @return type FALSE si no existe el parametro
     */
    public function input_post($item, $xss = TRUE) {
        
        return $this->ci->input->post($item, $xss);
        
    }
    
    /**
     * Obtiene un parametro tipo GET
     * 
     * @param type $item Nombre del parametro a obtener
     * @param type $xss Aplica fltros XSS
     * @return type FALSE si no existe el parametro
     */
    public function input_get($item, $xss = TRUE) {
        
        return $this->ci->input->get($item, $xss);
        
    }
    
    public function input_get_ip() {
        
        if($this->ci->input->is_cli_request()) {
            
            return '127.0.0.1';
            
        }
        
        $ip = $this->ci->input->ip_address();
        
        return ($ip == '0.0.0.0' ? FALSE : $ip);
        
    }
    
    public function input_is_ajax_request() {
        
        return $this->ci->input->is_ajax_request();
        
    }
    
    /**
     * Carga un modelo
     * 
     * @param String $name Nombre del modelo
     * @param type $nameKey Nombre a usar en el $this
     * @return boolean TRUE/FALSE si el modelo esta cargado y configurado
     */
    public function load_model($name, $nameKey = '', $dbConnect = FALSE) {
        
        /* cargamos el modelo */
        $this->ci->load->model($name, $nameKey, $dbConnect);
        return TRUE;
        
    }
    
    /**
     * Carga un helper
     * 
     * @param type $name Nombre del helper
     * @param type $sufijo Agregar sufijo CI
     */
    public function load_helper($name, $sufijo = '') {
        
        $this->ci->load->helper($name, $sufijo);
        
    }
    
    /**
     * Obtiene un elemento del archivo de lenguaje, si el elemento no existe 
     * intenta cargar el archivo de lenguaje especificado en el segudo parametro
     * 
     * @param type $item
     * @return type Retorna un elemento del archivo de lenguaje
     */
    public function lang_get($item, $file = '') {
        
        /* obtenemos el item del lenguaje */
        $itemLang = $this->ci->lang->line($item);
        
        /* verificamos si se obtuvo el item */
        if($itemLang === FALSE && $file != '') {
            
            /* cargamos el idioma especificado */
            $this->load_lang($file, '', FALSE);
            
            /* obtenemos y verificamos el item del lenguaje */
            if(FALSE=== ($itemLang = $this->ci->lang->line($item))) {
                
                $itemLang = 'Elemento de lenguaje no especificado:'.$item;
                
            }
            
        }
        
        return $itemLang;
        
    }
    
    public function session_get_flash($item) {
        
        return $this->ci->session->flashdata($item);
        
    }
    
    public function session_set_flash($item, $value) {
        
        $this->ci->session->set_flashdata($item, $value);
        
    }
    
    public function session_destroy() {
        
        $this->ci->session->sess_destroy();
        
    }
    
    public function redirect($location) {
        
        $this->header_set_php('Location: ' . $location);
        exit;
        
    }
    
}
