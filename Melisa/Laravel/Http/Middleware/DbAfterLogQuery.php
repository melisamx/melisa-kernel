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
            
            foreach($queryLog['bindings'] as $binding) {
                
                $queryLog['query'] = str_replace_first(
                    '?', 
                    $binding, 
                    $queryLog['query']);
                
            }
            
            $logData .= $queryLog['query'] . PHP_EOL;
            
        }
        
        if($logData) {
            
            logger()->info('Queries executed on '. 
                    $request->url() . 
                    ' (' .count($querysLog) . ')' .
                    ": " . 
                    PHP_EOL . 
                    $logData
            );
            
        }

        return $response;
        
    }
    
}
