<?php

namespace Melisa\Laravel\Database;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait CleanLogsSeeder
{
    
    public function cleanLogs()
    {        
        $path = storage_path() . '/logs/laravel.log';
        @unlink($path);        
    }
    
}
