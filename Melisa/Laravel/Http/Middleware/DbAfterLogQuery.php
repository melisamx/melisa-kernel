<?php namespace Melisa\Laravel\Http\Middleware;

use Closure;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class DbAfterLogQuery
{
    
    public function handle($request, Closure $next, $guard = null)
    {
        
        $response = $next($request);
        
        $querysLog = \DB::getQueryLog();
        
        $logData = '';
        
        foreach($querysLog as $queryLog) {
            
            $logData .= str_replace_first('?', $queryLog['bindings'], $queryLog['query']);
            $logData .= PHP_EOL;
            
        }
        
        if($logData) {
            
            \Log::info('Queries executed on '. $request->url() . ": " . count($querysLog));
            \Log::info('Queries executed: ' . PHP_EOL . $logData );
            
        }

        return $response;
        
    }
    
}
