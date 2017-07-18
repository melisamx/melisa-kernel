<?php

namespace Melisa\Laravel\Http\Validations;

/**
 * Validate number container
 *
 * @author Luis Josafat Heredia Contreras
 */
class NumberContainerValidation extends CustomValidation
{
    
    public function name()
    {
        return 'container';
    }
    
    public function errorMessage()
    {
        return 'Numero de contenedor invalido';
    }
    
    public function test()
    {
        return function($attribute, $value, $parameters, $validator)
        {
            $characters = '0123456789A_BCDEFGHIJK_LMNOPQRSTU_VWXYZ';
            $regex = '/^[A-Z]{4}[0-9]{7}$/';
            $nValue = 0;
            $nTotal = 0;
            $nPow2 = 1;

            if( strlen($value) !== 11) {
                return false;
            }

            if( !preg_match($regex, $value)) {
                return false;
            }

            for($i = 0; $i < 10; $i++) {
                $nValue = strrpos($characters, substr($value, $i, 1));

                if( $nValue < 0) return false;

                $nTotal += $nValue * $nPow2;
                $nPow2 *=2;
            }

            $nTotal = $nTotal % 11;
            if( $nTotal >= 10) {
                $nTotal = 0;
            }

            return substr($value, 10) === (string) $nTotal;
        };
    }
    
}
