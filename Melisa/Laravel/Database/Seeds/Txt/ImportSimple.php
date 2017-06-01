<?php

namespace Melisa\Laravel\Database\Seeds\Txt;

use Melisa\Kernel\Database\Seeds\Txt\ImportSimple as KernelImportSimple;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait ImportSimple
{
    
    public function txtImportSimple(array $files = [], $keyConnection = null)
    {        
        return app(KernelImportSimple::class)->init($files, $keyConnection);        
    }
    
}
