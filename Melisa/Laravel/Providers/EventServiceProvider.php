<?php namespace Melisa\Laravel\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    
    protected $listen = [
        'App\Core\Events\ModuleAccessEvent' => [
            'App\Core\Listeners\ModuleAccessBinacleListener',
        ],
        'Illuminate\Auth\Events\Login' => [
            'App\Core\Listeners\LoginSuccessListener',
        ],
    ];
    
}
