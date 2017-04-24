<?php namespace Melisa\Kernel\Database\Seeds\Module;

use Melisa\core\LogicBusiness;
use App\Core\Logics\Modules\Install;

/**
 * Instalation module definition in format json
 *
 * @author Luis Josafat Heredia Contreras
 */
class InstallJson
{
    use LogicBusiness;
    
    public function init($path, $filesName)
    {
        
        $path = $this->getPathImport($path);
        
        if( !$this->existPath($path)) {
            return $this->error('no exist path import {p}', [
                'p'=>$path
            ]);
        }
        
        if( !$this->processFile($path, $filesName)) {
            return false;
        }
        
        $this->debug('import all files success!!');
        return true;
        
    }
    
    public function processFile($path, $filesName)
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
            
            if( !$this->installModule($content)) {
                return false;
            }
            
            $this->debug('import file {f} success!!', [
                'f'=>$file
            ]);
            
        }
        
    }
    
    public function installModule($config)
    {
        $class = $this->getInstanceClass();        
        return $class->init([
            $config
        ]);        
    }
    
    public function getInstanceClass()
    {
        static $class = null;
        
        if( $class) {
            return $class;
        }
        
        $class = app(Install::class);
        return $class;
        
    }
    
    public function isValidContent($content)
    {
        return is_null($content) ? false : true;
    }
    
    public function getContentFile($path)
    {
        return json_decode(file_get_contents($path), true);
    }
    
    public function getPathFile($pathBase, $file)
    {
        return $pathBase . "$file.json";
    }
    
    public function existPath($path)
    {
        return file_exists($path);
    }
    
    public function getPathImport($path)
    {
        return base_path() . "/Database/Seeds/Modules/$path/";
    }
    
}
