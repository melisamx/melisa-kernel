<?php namespace Melisa\Laravel\Models;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class BaseUuid extends Base
{
    
    use UuidForKey;
    public $incrementing = FALSE;
    
}
