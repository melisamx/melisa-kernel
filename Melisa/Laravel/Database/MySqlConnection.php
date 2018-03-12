<?php

namespace Melisa\Laravel\Database;

use Melisa\Laravel\Database\Schema\Blueprint;
use Illuminate\Database\MySqlConnection as ParentMySqlConnection;
use Illuminate\Database\Schema\MySqlBuilder;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class MySqlConnection extends ParentMySqlConnection
{
    
    /**
     * Get a schema builder instance for the connection.
     * Set {@see \App\Database\Schema\Blueprint} for connection
     * Blueprint resolver
     *
     * @return \Illuminate\Database\Schema\MySqlBuilder
     */
    public function getSchemaBuilder()
    {
        if (is_null($this->schemaGrammar)) {
            $this->useDefaultSchemaGrammar();
        }
        $builder = new MySqlBuilder($this);
        $builder->blueprintResolver(function ($table, $callback) {
            return new Blueprint($table, $callback);
        });
        return $builder;
    }
    
}
