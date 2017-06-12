<?php

namespace Melisa\Laravel\Http;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class KernelSecure extends KernelAbstract
{
    
    protected $middlewareGroups = [
        'web' => [
            \Melisa\Laravel\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Melisa\Laravel\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Security\Http\Middleware\CheckIsUserActivated::class,
        ],
        
        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];
    
}
