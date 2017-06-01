<?php

namespace Melisa\Laravel\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifyCsrf;

/**
 * 
 * @author Luis Josafat Heredia Contreras
 */
class VerifyCsrfToken extends BaseVerifyCsrf
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];
    
}
