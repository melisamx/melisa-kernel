<?php namespace Melisa\Laravel\Services;

use Melisa\libraries\Uuid;

/**
 * Generate uuid
 *
 * @author Luis Josafat Heredia Contreras
 */
class UuidServices extends Uuid
{
    
    public function v5($name = null, $nameSpace = null)
    {
        
        if( is_null($name)) {
            $name = config('app.name');
        }
        
        return parent::v5($name);
        
    }
    
}
