<?php namespace Melisa\laravel\Auth;

use Illuminate\Auth\Passwords\DatabaseTokenRepository;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class TokenRepository extends DatabaseTokenRepository
{
    
    /**
     * Build the record payload for the table.
     *
     * @param  string  $email
     * @param  string  $token
     * @return array
     */
    protected function getPayload($email, $token)
    {
        return ['email' => $email, 'token' => $token];
    }
    
}
