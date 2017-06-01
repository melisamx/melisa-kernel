<?php

namespace Melisa\Laravel\Database\Seeds\Module;

use Melisa\Kernel\Database\Seeds\Module\InstallJson as InstallModuleJson;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait InstallJson
{
    
    public function installModuleJson($path, $files)
    {        
        return app(InstallModuleJson::class)->init($path, $files);        
    }
    
}
