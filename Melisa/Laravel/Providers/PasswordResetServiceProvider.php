<?php namespace Melisa\Laravel\Providers;

use Illuminate\Auth\Passwords\PasswordResetServiceProvider as BasePasswordReset;
use Melisa\Laravel\Auth\PasswordBrokerManager;

/**
 * Necesary for create passwork reset fields table diferent
 *
 * @author Luis Josafat Heredia Contreras
 */
class PasswordResetServiceProvider extends BasePasswordReset
{
    
    protected function registerPasswordBroker()
    {
        $this->app->singleton('auth.password', function ($app) {
            return new PasswordBrokerManager($app);
        });

        $this->app->bind('auth.password.broker', function ($app) {
            return $app->make('auth.password')->broker();
        });
    }
    
}
