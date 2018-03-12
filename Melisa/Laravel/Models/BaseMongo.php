<?php 

namespace Melisa\Laravel\Models;

use Melisa\core\orm\ErrorHumanTrait;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class BaseMongo extends Model
{    
    use ErrorHumanTrait,
        NoUpdateCreate,
        CreateTrait,
        UpdateTrait;
    
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
    
}
