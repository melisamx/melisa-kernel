<?php

namespace Melisa\core;

class LogicBusiness extends Base
{
    
    public function input() {
        
        return load()->libraries(__NAMESPACE__ . '\Input');
        
    }
    
}
