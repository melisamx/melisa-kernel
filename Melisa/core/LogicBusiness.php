<?php namespace Melisa\core;

trait LogicBusiness
{
    
    public function error($message, array $data = []) {
        
        return melisa('logger')->error($message, $data);
        
    }
    
}
