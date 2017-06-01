<?php

namespace Melisa\Kernel\Database\Seeds\Csv;

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
    
    /**
     * Extract to http://php.net/manual/es/function.str-getcsv.php
     * @param type $filename
     * @return array
     */
    public function getContentFile($filename)
    {
        $header = NULL;
        $data = array();
        $delimiter = ',';
        
        if (($handle = fopen($filename, 'r')) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                if(!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
        return $data;
    }
    
}
