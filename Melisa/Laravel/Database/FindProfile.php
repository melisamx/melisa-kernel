<?php namespace Melisa\Laravel\Database;

use App\Core\Models\Profiles;

trait FindProfile
{
    
    public function FindProfile($key) {
        
        return Profiles::where('key', $key)->first();
        
    }
    
}
