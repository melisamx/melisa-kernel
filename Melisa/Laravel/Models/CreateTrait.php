<?php namespace Melisa\Laravel\Models;

use Illuminate\Database\QueryException;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait CreateTrait
{    
    
    public static function create(array $input = []) {
        
        try {
            
            $result = parent::create($input);
            
        } catch (QueryException $ex) {
            
            $result = false;
            \Log::error(static::errorHuman($ex->getMessage(), $ex->errorInfo, $input));
            
        }
        
        if( $result === false) {
            
            return false;
            
        }
        
        return $result->id;
        
    }
    
}