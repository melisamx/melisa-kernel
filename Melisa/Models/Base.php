<?php 

namespace Melisa\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Melisa\core\orm\ErrorHumanTrait;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class Base extends Model
{
    
    use ErrorHumanTrait;
    
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
    public $incrementing = FALSE;
    
    public static function create(array $input = []) {
        
        try {
            exit(var_dump($input));
            $result = parent::create($input);
            
        } catch (QueryException $ex) {
            
            $result = FALSE;
            logger()->error(static::errorHuman($ex->getMessage(), $ex->errorInfo, $input));
            
        }
        
        if( $result === FALSE) {
            
            return FALSE;
            
        }
        
        return $result->id;
        
    }
    
}
