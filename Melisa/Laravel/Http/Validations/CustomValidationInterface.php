<?php

namespace Melisa\Laravel\Http\Validations;

/**
 * Description of CustomValidation
 *
 * @author Luis Josafat Heredia Contreras
 */
interface CustomValidationInterface
{
    
    public function name();
    public function test();
    public function errorMessage();
    
}
