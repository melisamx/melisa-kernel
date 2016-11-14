<?php namespace Melisa\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseMacroServiceProvider extends ServiceProvider
{
    
    public function boot()
    {
        
        Response::macro('create', function($value) {
            
            $data = [
                'success'=>$value ? true : false,
            ];
            
            $messages = melisa('msg')->get();
            
            if( !env('benchmark')) {
                
                $data ['benchmark']= round(memory_get_usage() / 1024 / 1024, 2) . 'MB';
                
            }
            
            if( is_array($value)) {
                
                $data += $value;
                
            } else {
                
                $data ['id']= $value;
                
            }
            
            $response = melisa('array')->mergeDefault($messages, $data);
            
            if( $value) {
                
                return Response::json($response);
                
            }
            
            return Response::json($response)->header('Content-Status', 400);
            
        });
        
    }
    
}
