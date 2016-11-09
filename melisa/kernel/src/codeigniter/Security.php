<?php 

namespace Melisa\codeigniter;

/**
 * @author Luis Josafat Heredia Contreras
 */
class Security extends \CI_Security
{
    
    var $csrfIsOk = TRUE;
    var $csrfIsError = '';
    
    public function csrf_verify() {

        // If it's not a POST request we will set the CSRF cookie
        if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST') {
            
            return $this->csrf_set_cookie();
            
        }
        
        // Do the tokens exist in both the _POST and _COOKIE arrays?
		if ( ! isset($_POST[$this->_csrf_token_name], $_COOKIE[$this->_csrf_cookie_name])) {
            
			/* establecemos la bandera de que csrf detectado */
            $this->csrfIsOk = FALSE;
        
            /* marcamos el error */
            $this->csrfIsError = 'token_cookie';
            
            log_message('debug', 'CSRF token csrf no recibido');
            
            return $this;
            
		}
        
        if( !$this->csrfIsOk) {
            
            return $this;
            
        }
        
        /* Do the tokens match? */
        if ($_POST[$this->_csrf_token_name] != $_COOKIE[$this->_csrf_cookie_name])
        {

            /* establecemos la bandera de que csrf detectado */
            $this->csrfIsOk=FALSE;

            /* marcamos el error */
            $this->csrfIsError = 'tokens_diferentes';

            log_message('debug', 'CSRF los tokens no coinciden');
            
            return $this;

        }
        
        /* We kill this since we're done and we don't want to
         * polute the _POST array
         */
        unset($_POST[$this->_csrf_token_name]);
        
        /* Nothing should last forever */
        unset($_COOKIE[$this->_csrf_cookie_name]);
        
        $this->_csrf_set_hash();
        $this->csrf_set_cookie();

        log_message('debug', 'CSRF token verified');

        return $this;
        
    }
    
    public function verificar_csrf() {
        
        /* verificamos si la proteccion esta activada */        
        if( !config_item('csrf_protection')) {
            
            return TRUE;
            
        }
        
        return $this->csrfIsOk;
        
    }
    
    public function csrf_error_get() {
        
        return $this->csrfIsError;
        
    }
    
}
