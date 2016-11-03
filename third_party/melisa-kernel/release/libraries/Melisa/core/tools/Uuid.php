<?php 

namespace Melisa\core\tools;

require_once MYINSTALLROOT . 'third_party/ci-uuid/Uuid.php';

/**
 * Generate uuid
 *
 * @author Luis Josafat Heredia Contreras
 */
class Uuid extends \Uuid
{
    
    public function generate() {
        
        static $code = NULL;
        
        if( !$code) {
            
            $appCode = app()->app;
            
            $code = $appCode ? $appCode : 'Melisa';
            
        }
        
        return $this->v5($code);
        
    }
    
}
