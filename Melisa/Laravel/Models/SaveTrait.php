<?php 

namespace Melisa\Laravel\Models;

use Illuminate\Database\QueryException;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait SaveTrait
{    
    
    public function save(array $options = [])
    {        
        dd($options);
        try {            
            $result = parent::update($input);            
        } catch (QueryException $ex) {            
            $result = false;
            melisa('logger')->error(static::errorHuman($ex->getMessage(), $ex->errorInfo, $input));            
        }
        dd($result);
        if( $result === false) {            
            return false;            
        }
        
        return $result->id;        
    }
    
}
