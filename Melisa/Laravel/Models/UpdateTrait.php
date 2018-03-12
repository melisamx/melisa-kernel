<?php 

namespace Melisa\Laravel\Models;

use Illuminate\Database\QueryException;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait UpdateTrait
{    
    
    public function update(array $attributes = [], array $options = [])
    {        
        dd($attributes);
        try {            
            $result = parent::update($input);            
        } catch (QueryException $ex) {            
            $result = false;
            app('messages')->error(static::errorHuman($ex->getMessage(), $ex->errorInfo, $input));            
        }
        dd($result);
        if( $result === false) {            
            return false;            
        }
        
        return $result->id;        
    }
    
}
