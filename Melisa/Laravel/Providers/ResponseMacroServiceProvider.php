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
        
        Response::macro('create', function ($value) {
            
            $data = [
                'success'=>$value ? true : false
            ];
            
            $messages = melisa('msg')->get();
            
            $response = melisa('array')->mergeDefault($data, $messages);
            
            if( $value) {
                
                return Response::json($response);
                
            }
            
            return Response::json($response)
                ->header('Content-Status', 400);
            
        });
        
    }
    
}
