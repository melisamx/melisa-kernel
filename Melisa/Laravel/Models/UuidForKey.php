<?php

namespace Melisa\Laravel\Models;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait UuidForKey
{
    
    /**
     * Boot the Uuid trait for the model.
     *
     * @return void
     */
    public static function bootUuidForKey()
    {
        static::creating(function($model) {
            $model->incrementing = false;
            
            /* required for use seeder */
            if( $model->id) {                
                return true;                
            }
            
            $model->{$model->getKeyName()} = app('uuid')->v5();            
        });
        
    }
    
    /**
     * necesary laravel 5.6
     */
    public static function boot()
    {
        static::creating(function($model) {
            
            $model->incrementing = false;
            
            /* required for use seeder */
            if( $model->id) {                
                return true;                
            }
            
            $model->{$model->getKeyName()} = app('uuid')->v5();            
        });
    }
    
}
