<?php 

namespace Melisa\codeigniter;

/**
 * @author Luis Josafat Heredia Contreras
 */
class Log extends \CI_Log
{
    
    public function write_log($level = 'error', $msg = '', $php_error = FALSE) {
        
        if ($this->_enabled === FALSE) {
            
			return FALSE;
            
		}

		$level = strtoupper($level);

		if ( ! isset($this->_levels[$level]) OR ($this->_levels[$level] > $this->_threshold)) {
            
			return FALSE;
            
		}
        
        $filepath = $this->_log_path . 'log.log';
		$message  = '';

		if ( ! $fp = @fopen($filepath, FOPEN_WRITE_CREATE)) {
            
			return FALSE;
            
		}

		$message .= $level.' '.(($level == 'INFO') ? ' -' : '-').' '.date($this->_date_fmt). ' --> '.$msg."\n";

		flock($fp, LOCK_EX);
		fwrite($fp, $message);
		flock($fp, LOCK_UN);
		fclose($fp);

		@chmod($filepath, FILE_WRITE_MODE);
		return TRUE;
        
    }
    
}
