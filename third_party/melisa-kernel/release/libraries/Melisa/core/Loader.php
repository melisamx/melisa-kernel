<?php

namespace Melisa\core;
use Melisa\core\Base;

/* 
 * Loader libraries and logics
 * 
 */
class Loader extends Base
{
    
    public function libraries($library, $params =NULL) {
        
        return loader($library, 'libraries', $params);
        
    }
    
    public function logic($logic, $path = '') {
        
        return loader($logic, 'logics/' . $path);
        
    }
    
}
