<?php namespace Melisa\Laravel\Database;

use App\Core\Models\Applications;

trait FindApplication
{
    
    public function findApplication($key) {
        
        return Applications::where('key', $key)->first();
        
    }
    
}
