<?php namespace Melisa\Laravel\Console\Commands;

use Illuminate\Console\Command;
use App\Core\Console\Commands\RepositoriesGenerate;

/**
 * Description of Repositories
 *
 * @author Luis Josafat Heredia Contreras
 */
class Repositories extends Command
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repositories {connection=mysql}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    
    protected $logic;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(RepositoriesGenerate $logic)
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
            
            $this->error('Imposible create Class repositories');
            
        } else {
            
            $this->info('Success!!');
        }
        
    }
    
}
