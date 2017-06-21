<?php

namespace Melisa\Laravel\Modules;

/**
 * Interface render modules
 *
 * @author Luis Josafat Heredia Contreras
 */
interface OutbuildingsInterface
{
    
    public function render();
    
    public function getInput();
    
    public function withInput($input);
    
}
