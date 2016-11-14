<?php namespace Melisa\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseMacroServiceProvider extends ServiceProvider
{
    
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        Response::macro('create', function($value) {
            
            $data = [
                'success'=>$value ? $value : false,
            ];
            
            $messages = melisa('msg')->get();
            
            if( !env('benchmark')) {
                
                $data ['benchmark']= round(memory_get_usage() / 1024 / 1024, 2) . 'MB';
                
            }
            
            $response = melisa('array')->mergeDefault($data, $messages);
            
            if( $value) {
                
                return Response::json($response);
                
            }
            
            return Response::json($response)->header('Content-Status', 400);
            
        });
        
    }
    
}
