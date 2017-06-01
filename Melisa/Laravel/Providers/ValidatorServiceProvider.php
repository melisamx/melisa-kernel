<?php

namespace Melisa\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Melisa\Laravel\Services\CustomValidator;

/**
 * si funcionan pero si queremos personalizar la validación de cada filter no 
 * hay forma de pasar parametros
 * 
 * @author Luis Josafat Heredia Contreras
 */
class ValidatorServiceProvider extends ServiceProvider
{
    
    public function boot()
    {
        
        \Validator::resolver(function($translator, $data, $rules, $messages)
        {
            return new CustomValidator($translator, $data, $rules, $messages);
        });
        
    }
    
}
