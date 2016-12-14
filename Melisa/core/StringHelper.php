<?php namespace Melisa\core;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class StringHelper
{
    
    public function startsWith($haystack, $needle) {
        
        $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
        
    }
    
    public function endsWith($haystack, $needle) {
        
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
        
    }
    
}
