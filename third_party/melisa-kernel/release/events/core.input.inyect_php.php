<?php 

Event()->listen('core.input.inyect_php', function($field, &$value) {
    
    return get_instance()->app->load()->libraries('Melisa\core\input\Inyect')
        ->init($field, $value);
    
});
