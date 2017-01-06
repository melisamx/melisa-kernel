<?php namespace Melisa\Laravel\Console\Commands;

use Illuminate\Console\Command;

/**
 * Generate models
 *
 * @author Luis Josafat Heredia Contreras
 */
class Faker extends Command
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'faker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run faker';
    
    protected $logic;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        $class = app()->getNameSpace() . '\Database\Seeds\FakerSeeder';
        
        $this->call('db:seed', [
            '--class'=>$class
        ]);
        
    }
    
}
