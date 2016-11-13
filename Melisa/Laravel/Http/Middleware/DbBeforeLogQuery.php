<?php namespace Melisa\Laravel\Http\Middleware;

use Closure;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class DbBeforeLogQuery
{
    
    public function handle($request, Closure $next, $guard = null)
    {
        
        \DB::connection()->enableQueryLog();      

        return $next($request);
        
    }
    
}
