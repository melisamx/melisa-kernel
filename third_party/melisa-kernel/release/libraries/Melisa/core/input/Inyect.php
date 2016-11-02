<?php 

namespace Melisa\core\input;

use Melisa\core\Base;

/**
 * Inyect data in input required
 *
 * @author Luis Josafat Heredia Contreras
 */
class Inyect extends Base
{
    
    public function init($field, &$value) {
        
        return $this->process([
            'sessionIdIdentity',
            'sessionIdUser',
            'utilNull',
        ], $field, $value);
        
    }
    
    public function process($functions, $field, &$value) {
        
        $flag = TRUE;
        
        foreach($functions as $function) {
            
            $result = $this->{$function}($field, $value);
            
            if( !$result) {
                
                $flag = FALSE;
                break;
                
            }
            
        }
        
        return $flag;
        
    }
    
    public function sessionIdIdentity($field, &$value) {
        
        if($value !== '{session.idIdentity}') {
            
            return TRUE;
            
        }
        
        return TRUE;
        
    }
    
    public function sessionIdUser($field, &$value) {
        
        if($value !== '{session.idUser}') {
            
            return TRUE;
            
        }
        
        $idUser = $this->getApp()
            ->load()
            ->libraries('Melisa\core\Session')
            ->get('idUser');
        
        if( !$idUser) {
            
            return logger()->error('{c}. Imposible get sessión item {i}', [
                'c'=>__CLASS__,
                'i'=>$field
            ]);
        }
        
        $value = $idUser;
        
        return TRUE;
        
    }
    
    public function utilNull($field, &$value) {
        
        if($value !== '{util.null}') {
            
            return TRUE;
            
        }
        
        $value = NULL;
        return TRUE;
        
    }
    
}
