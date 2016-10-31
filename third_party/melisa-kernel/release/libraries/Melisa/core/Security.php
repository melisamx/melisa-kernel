<?php

namespace Melisa\core;

use Melisa\core\Base;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class Security extends Base
{
    
    private $tasksRequired = [
        'all'
    ];
    
    public function __construct() {
        
        $this->log()->debug(__CLASS__ . ' Class Initialized');
        
    }

    public function init($tasks = NULL, $silentError = FALSE) {
        
        if( !is_null($tasks)) {
            
            $this->setTasksRequired($tasks);
            
        }
        
        $this->log()->debug('Validate tarks required: {t}', [
            't'=>implode(PHP_EOL, $this->tasksRequired)
        ]);
        
        
        
    }
    
    public function setTasksRequired($tasks) {
        
        if( array($tasks)) {
            
            foreach($tasks as $task) {
                
                $this->setTasksRequired($task);
                
            }
            
            return;
            
        }
        
        if( in_array($task, $this->tasksRequired)) {
            
            return;
            
        }
        
        $this->tasksRequired []= $task;
        return;
        
    }
    
}
