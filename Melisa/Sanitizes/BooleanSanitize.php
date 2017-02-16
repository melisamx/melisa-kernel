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
        
        return in_array($value, [
            'false',
            0,
            '0'
        ], true) ? 0 : true;
        
    }
    
}
