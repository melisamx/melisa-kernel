<?php

namespace Melisa\Kernel\Database\Seeds\Txt;

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
        return $pathBase . "$file.txt";
    }
    
    public function getContentFile($path)
    {
        $data = explode(PHP_EOL, file_get_contents($path));
        
        if( empty($data)) {
            return null;
        }
        
        $key = $data[0]; 
        $records = [];
        unset($data[0]);
        foreach($data as $line) {
            $records []= [
                $key=>$line
            ];
        }
        
        return $records;
    }
    
}
