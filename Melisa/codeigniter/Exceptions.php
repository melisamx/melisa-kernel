<?php

namespace Melisa\codeigniter;

/**
 * @author Luis Josafat Heredia Contreras
 */
class Exceptions extends \CI_Exceptions
{
    
    public function show_404($page = '', $log = TRUE) {
        
        $title = 'Pagina no encontrada';
        $msg = 'La pagina solicitada no fue encontrada';
        
        if($log && ENVIRONMENT == 'development') {
            
            log_message('error', 'Pagina no encontrada --> ' . $page);
            
        }

        echo $this->show_error($title, $msg, 'error_404', 404);
        exit;
        
    }
    
}
