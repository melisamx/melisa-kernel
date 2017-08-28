<?php

namespace Melisa\Laravel\Console\Commands;

use Illuminate\Console\Command;
use App\Core\Console\Commands\ModelsGenerate;

/**
 * Generate models
 *
 * @author Luis Josafat Heredia Contreras
 */
class Models extends Command
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'models {connection=mysql}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate models from database';
    
    protected $logic;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ModelsGenerate $logic)
    {
        parent::__construct();        
        $this->logic = $logic;        
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {        
        $connection = $this->argument('connection');
        
        if( $connection === 'mysql') {            
            $connections = config('database.connections');            
            $connection = $this->choice('Database use?', array_keys($connections), 1);            
        }
        
        $result = $this->logic->init($connection);
        
        if( !$result) {            
            $this->error('Imposible create Class models');            
        } else {            
            $this->info('Success!!');
        }
    }
    
}
