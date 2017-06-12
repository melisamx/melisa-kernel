<?php

namespace Melisa\Laravel\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * 
 * @author Luis Josafat Heredia Contreras
 */
class RedirectIfAuthenticated
{
    
    protected $redirect = '/panel.php/#home';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {        
        if (Auth::guard($guard)->check()) {
            return redirect($this->redirect);            
        }        

        return $next($request);        
    }
    
}
