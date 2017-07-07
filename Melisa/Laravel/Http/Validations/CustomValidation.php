<?php

namespace Melisa\Laravel\Http\Validations;

/**
 * Custom validation
 *
 * @author Luis Josafat Heredia Contreras
 */
class CustomValidation implements CustomValidationInterface
{
    
    protected $name;
    protected $errorMessage = 'Custom error message';

    public function name()
    {
        return $this->name;
    }

    public function test()
    {
        return true;
    }

    public function errorMessage()
    {
        return $this->errorMessage;
    }
    
}
