<?php

namespace Melisa\Laravel\Models;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait SaveAllUppercaseTrait
{

    public function setAttribute($key, $value)
    {
        parent::setAttribute($key, $value);
        $this->saveUpperCase($key, $value);
    }
    
    public function saveUpperCase($key, $value)
    {
        if( is_string($value) && isset($this->noUppercase) && in_array($key, $this->noUppercase)) {
            return;
        }
        
        if(is_string($value)) {
            $this->attributes [$key]= trim(mb_strtoupper($value));
        }
    }
    
}
