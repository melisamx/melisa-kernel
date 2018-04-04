<?php

namespace Melisa\Laravel\Http\Controllers;

use Melisa\Laravel\Http\Controllers\CrudController;
use Melisa\Laravel\Http\Controllers\ApiCrudTrait;

/**
 * Api crud controller
 *
 * @author Luis Josafat Heredia Contreras
 */
class ApiCrudController extends CrudController
{
    use ApiCrudTrait;
    
}
