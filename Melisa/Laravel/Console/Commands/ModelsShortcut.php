<?php

namespace Melisa\Laravel\Console\Commands;

use Melisa\Laravel\Console\Commands\Models;

/**
 * Shortcut generate models
 *
 * @author Luis Josafat Heredia Contreras
 */
class ModelsShortcut extends Models
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mo {connection=mysql}';
    
}
