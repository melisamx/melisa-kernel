<?php

namespace Melisa\contracts\database;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
interface ConnectionManagerInterface
{
    
    public function &load($group, array $config = []);
    
    public function create($group, $config = []);
    
    public function loadUtil($group, $config = []);
    
}
