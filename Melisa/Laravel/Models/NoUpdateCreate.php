<?php

namespace Melisa\Laravel\Models;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait NoUpdateCreate
{
    
    /**
     * Boot the Uuid trait for the model.
     *
     * @return void
     */
    public static function bootNoUpdateCreate()
    {        
        static::creating(function($model) {
            
            /**
             * fix seeder
             */
            if( !isset($model->updateAt)) {                
                return true;                
            }
            
            /* necesary but not updatedAt fill */
            $model->setUpdatedAt(NULL);
            
        });        
    }
    
}
