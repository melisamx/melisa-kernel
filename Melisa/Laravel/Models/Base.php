<?php namespace Melisa\Laravel\Models;

use Illuminate\Database\Eloquent\Model;
use Melisa\core\orm\ErrorHumanTrait;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class Base extends Model
{
    
    use ErrorHumanTrait, NoUpdateCreate, CreateTrait;
    
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
    
}
