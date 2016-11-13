<?php namespace Melisa\Laravel\Providers;

use Illuminate\Auth\Passwords\PasswordResetServiceProvider as BasePasswordReset;
use Melisa\Laravel\Auth\PasswordBrokerManager;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class PasswordResetServiceProvider extends BasePasswordReset
{
    
    /**
     * Register the password broker instance.
     *
     * @return void
     */
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
