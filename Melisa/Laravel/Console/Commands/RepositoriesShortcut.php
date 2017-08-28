<?php

namespace Melisa\Laravel\Console\Commands;

use Melisa\Laravel\Console\Commands\Repositories;

/**
 * Shortcut repositories command
 *
 * @author Luis Josafat Heredia Contreras
 */
class RepositoriesShortcut extends Repositories
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'r {connection=mysql}';
    
}
