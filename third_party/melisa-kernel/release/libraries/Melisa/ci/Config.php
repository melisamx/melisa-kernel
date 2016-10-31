<?php 

namespace Melisa\ci;

/**
 * @author Luis Josafat Heredia Contreras
 */
class Config extends \CI_Config
{
    
    /**
     * Agrega al _config_paths el directorio principal de la aplicación
     */
    public function __construct() {
        
        parent::__construct();
        
        $this->_config_paths []= MYAPPCORE;
        $this->_config_paths []= MYCORE;
        
    }
    
}
