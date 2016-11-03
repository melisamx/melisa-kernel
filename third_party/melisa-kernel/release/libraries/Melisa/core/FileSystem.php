<?php

namespace Melisa\core;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class FileSystem
{
    
    private $content = '';
    
    public function __construct() {
        
        logger()->debug(__CLASS__ . ' Class Initialized');
        
        get_instance()->abs->load_helper('file_helper');
        
    }
    
    public function read($path) {
        
        $this->content = read_file($path);
        return $this;
        
    }
    
    public function toJson(&$content = '', $assoc = TRUE) {
        
        return json_decode($content ? $content : $this->content, $assoc);
        
    }
    
}
