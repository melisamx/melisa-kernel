<?php

namespace Melisa\Laravel\Providers;

use Laravel\Passport\Passport;
use Carbon\Carbon;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * 
 * @author Luis Josafat Heredia Contreras
 */
class AuthServiceProvider extends ServiceProvider
{
    
    protected $policies = [];

    public function boot()
    {
        $this->registerPolicies();
        Passport::routes(function($router) {
            $router->forAccessTokens();
            $router->forTransientTokens();
        });
        Passport::tokensExpireIn(Carbon::now()->addDays(15));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
    }
    
}
