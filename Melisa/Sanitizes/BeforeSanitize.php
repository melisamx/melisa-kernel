<?php namespace Melisa\Sanitizes;

use Waavi\Sanitizer\Laravel\SanitizesInput;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait BeforeSanitize
{
    use SanitizesInput;
    
    /**
     *  Replace method sanitize
     *
     *  @return void
     */
    public function sanitize()
    {
        
        $sanitize = app()->make('sanitize');
        $sanitize->extend('boolean', BooleanSanitize::class);
        
        $this->sanitizer = $sanitize->make($this->input(), $this->sanitizes);
        $this->replace($this->sanitizer->sanitize());
        
    }
    
}
