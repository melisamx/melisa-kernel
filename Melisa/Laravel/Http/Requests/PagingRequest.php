<?php

namespace Melisa\Laravel\Http\Requests;

use Melisa\Laravel\Http\Requests\Generic;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class PagingRequest extends Generic
{
    
    protected $rules = [
        'page'=>'required|numeric',
        'start'=>'required|numeric',
        'limit'=>'required|numeric',
    ];
    
}
