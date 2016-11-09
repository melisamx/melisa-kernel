<?php

namespace Melisa\core\orm;

use Illuminate\Database\Eloquent\Builder;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait BootTrait
{
        
    public static function boot() {
        
        parent::boot();
        
        static::creating(function($model) {
            
            /* necesary by uuid pk */
            $model->{$model->getKeyName()} = uuid()->generate();
            
            /* necesary but not updatedAt fill */
            $model->setUpdatedAt(NULL);
            
        });
        
        static::addGlobalScope('isGod', function(Builder $builder) {
            
            $builder->where('isGod', '=', FALSE);
            
        });
        
    }
    
}
