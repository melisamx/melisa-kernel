<?php

namespace Melisa\Laravel\Http\Requests;

use Melisa\Laravel\Http\Requests\Generic;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class ActivateDeactivateRequest extends Generic
{
    
    protected $rules = [
        'id'=>'required|xss',
    ];
    
}
