<?php

namespace Melisa\Laravel\Console\Commands;

use Illuminate\Console\Command;

/**
 * Run seeders
 *
 * @author Luis Josafat Heredia Contreras
 */
class Seeders extends Command
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seeders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run seeders';
    
    protected $logic;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {        
        $class = app()->getNameSpace() . '\Database\Seeds\DatabaseSeeder';
        
        $this->call('db:seed', [
            '--class'=>$class
        ]);        
    }
    
}
