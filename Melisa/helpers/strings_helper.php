<?php

if ( !function_exists('str_contains')) {
    /**
     * Determine if a given string contains a given substring.
     *
     * @param string $haystack
     * @param string|array $needle
     * @return bool
     */
    function str_contains($haystack, $needles)
    {        
        foreach ((array) $needles as $needle) {
            if ($needle != '' && strpos($haystack, $needle) !== false) return true;
        }        
        return false;         
    }
    
}
