<?php namespace Melisa\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Melisa\Laravel\Services\FilterValidator;

/**
 * si funcionan pero si queremos personalizar la validación de cada filter no 
 * hay forma de pasar parametros
 */
class FilterValidatorServiceProvider extends ServiceProvider
{
    
    public function boot()
    {
        
        \Validator::resolver(function($translator, $data, $rules, $messages)
        {
            return new FilterValidator($translator, $data, $rules, $messages);
        });
        
    }
    
}
