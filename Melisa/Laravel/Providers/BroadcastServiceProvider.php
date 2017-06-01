<?php

namespace Melisa\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

/**
 * 
 * @author Luis Josafat Heredia Contreras
 */
class BroadcastServiceProvider extends ServiceProvider
{
    
    public function boot()
    {
        Broadcast::routes();
        /*
         * Authenticate the user's personal channel...
         */
        Broadcast::channel('App.User.*', function ($user, $userId) {
            return (int) $user->id === (int) $userId;
        });
    }
    
}
