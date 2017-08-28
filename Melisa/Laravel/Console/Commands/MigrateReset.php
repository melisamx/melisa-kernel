<?php

namespace Melisa\Laravel\Console\Commands;

use Illuminate\Console\Command;

/**
 * Reset database app
 *
 * @author Luis Josafat Heredia Contreras
 */
class MigrateReset extends Command
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mr';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset migrate database app';
    
    protected $logic;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {        
        $database = config('app.keyapp');
        
        return $this->call('migrate:reset', [
            '--database'=>$database
        ]);
    }
    
}
