<?php namespace Melisa\Sanitizes;

use Waavi\Sanitizer\Contracts\Filter;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class BooleanSanitize implements Filter
{
    
    /**
     * Required by Sencha components
     * @param string $value
     * @param array $options
     * @return bool
     */
    public function apply($value, $options = [])
    {
        
        return $value === 'false' ? false : true;
        
    }
    
}
