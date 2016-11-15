<?php namespace Melisa\Laravel\Models;

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
            
            $uuid = app('Melisa\libraries\Uuid');
            $model->{$model->getKeyName()} = $uuid->v5(config('app.name'));
            
        });
        
    }
    
}
