<?php namespace Melisa\Kernel\Database\Seeds\Json;

use Melisa\core\LogicBusiness;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class ImportSimple
{
    use LogicBusiness;
    
    public function init($filesName = [], $keyConnection = null) {
        
        $path = $this->getPathImport();
        
        if( !$this->existPath($path)) {
            return $this->error('no exist path import {p}', [
                'p'=>$path
            ]);
        }
        
        if( !$this->processFile($path, $filesName, $keyConnection)) {
            return false;
        }
        
        $this->debug('import all files success!!');
        return true;
        
    }
    
    public function getPathFile($pathBase, $file)
    {
        return $pathBase . "$file.json";
    }
    
    public function processFile($path, $filesName, $keyConnection)
    {
        
        if( !is_array($filesName)) {
            $filesName = [ $filesName ];
        }
        
        foreach($filesName as $file) {
            
            $filePath = $this->getPathFile($path, $file);
            
            if( !$this->existPath($filePath)) {
                return $this->error('no exist file import {f}', [
                    'f'=>$filePath
                ]);
            }
            
            $content = $this->getContentFile($filePath);
            
            if( !$this->isValidContent($content)) {
                return $this->error('invalid content file {f}', [
                    'f'=>$filePath
                ]);
            }
            
            if( !$this->importRecords($keyConnection, $file, $content)) {
                return false;
            }
            
            $this->debug('import file {f} success!!', [
                'f'=>$file
            ]);
                      
        }
        
        return true;
    }
    
    public function importRecords($keyConnection, $table, array &$records)
    {
        
        $connection = $this->getConnection($keyConnection);
        
        foreach($records as $record) {
            
            if( !$this->importRecord($connection, $table, $record)) {
                return $this->error('imposible import record in connection {c} on table {t}: {r}', [
                    'c'=>$keyConnection,
                    't'=>$table,
                    'r'=>json_encode($record)
                ]);
            }
            
        }
        
        return true;
    }
    
    public function importRecord(&$connection, $table, $record)
    {
        $table = $connection->table($table);
        
        $exist = $table->where($record)->first();
        
        if( is_null($exist)) {
            return $table->insert($record);
        }
        
        $table->where($record)->update($record);
        return true;
        
    }
    
    public function getConnection($keyConnection)
    {
        
        if( is_null($keyConnection)) {
            $keyConnection = config('app.keyapp');
        }
        
        return \DB::connection($keyConnection);
    }
    
    public function isValidContent($content)
    {
        return is_null($content) ? false : true;
    }
    
    public function getContentFile($path)
    {
        return json_decode(file_get_contents($path), true);
    }
    
    public function existPath($path)
    {
        return file_exists($path);
    }
    
    public function getPathImport()
    {
        return base_path() . '/Database/Seeds/Data/';
    }
    
}
