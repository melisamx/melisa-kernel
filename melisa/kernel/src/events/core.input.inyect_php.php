<?php 

event()->listen('core.input.inyect_php', function($field, &$value) {
    
    return load()->libraries('Melisa\core\input\Inyect')
        ->init($field, $value);
    
});
