<?php

namespace Melisa\Laravel\Http\Requests;

/**
 * Description of RequestInterface
 *
 * @author Luis Josafat Heredia Contreras
 */
interface RequestInterface
{
    
    public function allValid();
    
    public function rules();
    
}
