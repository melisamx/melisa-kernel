<?php

namespace Melisa\Laravel\Auth;

use Illuminate\Auth\Passwords\PasswordBrokerManager as BasePasswordBroker;
use Illuminate\Support\Str;
use Melisa\Laravel\Auth\TokenRepository;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class PasswordBrokerManager extends BasePasswordBroker
{
    
    /**
     * Create a token repository instance based on the given configuration.
     *
     * @param  array  $config
     * @return \Illuminate\Auth\Passwords\TokenRepositoryInterface
     */
    protected function createTokenRepository(array $config)
    {
        $key = $this->app['config']['app.key'];

        if (Str::startsWith($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }

        $connection = isset($config['connection']) ? $config['connection'] : null;

        return new TokenRepository(
            $this->app['db']->connection($connection),
            $this->app['hash'],
            $config['table'],
            $key,
            $config['expire']
        );
    }
    
}
