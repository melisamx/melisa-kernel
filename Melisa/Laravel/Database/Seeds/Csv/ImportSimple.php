<?php namespace Melisa\Laravel\Database\Seeds\Csv;

use Melisa\Kernel\Database\Seeds\Csv\ImportSimple as KernelImportSimple;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait ImportSimple
{
    
    public function csvImportSimple(array $files = [], $keyConnection = null) {
        
        return app(KernelImportSimple::class)->init($files, $keyConnection);
        
    }
    
}
