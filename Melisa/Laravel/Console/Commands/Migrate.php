<?php

namespace Melisa\Laravel\Console\Commands;

use Illuminate\Console\Command;

/**
 * Reset database app
 *
 * @author Luis Josafat Heredia Contreras
 */
class Migrate extends Command
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate database app';
    
    protected $logic;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {        
        $database = config('app.keyapp');
        
        return $this->call('migrate', [
            '--database'=>$database
        ]);
    }
    
}
