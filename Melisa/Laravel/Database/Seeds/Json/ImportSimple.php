<?php namespace Melisa\Laravel\Database\Seeds\Json;

use Melisa\Kernel\Database\Seeds\Json\ImportSimple as KernelImportSimple;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait ImportSimple
{
    
    public function jsonImportSimple(array $files = [], $keyConnection = null) {
        
        return app(KernelImportSimple::class)->init($files, $keyConnection);
        
    }
    
}
