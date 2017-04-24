<?php namespace Melisa\Kernel\Database\Seeds\Csv;

use Melisa\Kernel\Database\Seeds\Json\ImportSimple as JsonImportSimple;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class ImportSimple extends JsonImportSimple
{
    
    public function getPathFile($pathBase, $file)
    {
        return $pathBase . "$file.csv";
    }
    
    public function getContentFile($path)
    {
        dd(str_getcsv(file_get_contents($path)));
        return str_getcsv(file_get_contents($path));
    }
    
}
