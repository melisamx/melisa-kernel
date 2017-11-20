<?php

namespace Melisa\Laravel;

use Illuminate\Foundation\Application;

/**
 * 
 * @author Luis Josafat Heredia Contreras
 */
class ApplicationBase extends Application
{
    
    protected $appPaths = [];

    /**
     * Get the path to the application "app" directory.
     *
     * @return string
     */
    public function path($path = '')
    {
        return $this->basePath.'/app';
    }

    /**
     * Get the path to the database directory.
     *
     * @return string
     */
    public function databasePath($path = '')
    {
        return ($this->databasePath ?: $this->basePath.DIRECTORY_SEPARATOR.'Database').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
    
}
