<?php

namespace Melisa\Laravel\Database;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait Factory
{
    
    /**
     * for default search in database/factories
     */
    public function factory()
    {
        
        $factory = app(EloquentFactory::class);        
        $factory->load(base_path() .'/Database/factories');
        $arguments = func_get_args();
        
        if (isset($arguments[1]) && is_string($arguments[1])) {
            return $factory->of($arguments[0], $arguments[1])->times(isset($arguments[2]) ? $arguments[2] : 1);
        } elseif (isset($arguments[1])) {
            return $factory->of($arguments[0])->times($arguments[1]);
        } else {
            return $factory->of($arguments[0]);
        }        
    }
    
}
