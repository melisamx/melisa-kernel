<?php namespace Melisa\Laravel;

use Illuminate\Foundation\Application;

class ApplicationBase extends Application
{
    
    protected $appPaths = array();

    /**
     * Create a new Illuminate application instance.
     *
     * @param  array|null $appPaths
     * @return \MyApp
     */
    public function __construct($appPaths = null)
    {
        $this->registerBaseBindings();

        $this->registerBaseServiceProviders();

        $this->registerCoreContainerAliases();

        if (!is_array($appPaths)) {
            abort(500, '_construct requires paths array');
        }

        if (!isset($appPaths['base'])) {
            abort(500, '_construct requires base path');
        }

        $this->appPaths = $appPaths;

        $this->setBasePath($appPaths['base']);
    }

    /**
     * Set the base path for the application.
     *
     * @param  string  $basePath
     * @return $this
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;

        $this->bindPathsInContainer();

        return $this;
    }

    /**
     * Bind all of the application paths in the container.
     *
     * @return void
     */
    protected function bindPathsInContainer()
    {
        $this->instance('path', $this->path());

        foreach (['base', 'config', 'database', 'lang', 'public', 'storage', 'storageSession'] as $path)
        {
            $this->instance('path.'.$path, $this->{$path.'Path'}());
        }
    }

    /**
     * Get the path to the application "app" directory.
     *
     * @return string
     */
    public function path()
    {
        return $this->basePath.'/app';
    }

    /**
     * Get the base path of the Laravel installation.
     *
     * @return string
     */
    public function basePath()
    {
        return $this->basePath;
    }

    /**
     * Get the path to the application configuration files.
     *
     * @return string
     */
    public function configPath()
    {
        if (isset($this->appPaths['config'])) {
            return $this->appPaths['config'];
        }
        return $this->basePath.'/config';
    }

    /**
     * Get the path to the database directory.
     *
     * @return string
     */
    public function databasePath()
    {
        if (isset($this->appPaths['database'])) {
            return $this->appPaths['database'];
        }
        return $this->basePath.'/Database';
    }

    /**
     * Get the path to the language files.
     *
     * @return string
     */
    public function langPath()
    {
        if (isset($this->appPaths['lang'])) {
            return $this->appPaths['lang'];
        }
        return $this->basePath.'/resources/lang';
    }

    /**
     * Get the path to the public / web directory.
     *
     * @return string
     */
    public function publicPath()
    {
        if (isset($this->appPaths['public'])) {
            return $this->appPaths['public'];
        }
        return $this->basePath.'/public';
    }

    /**
     * Get the path to the storage directory.
     *
     * @return string
     */
    public function storagePath()
    {
        if (isset($this->appPaths['storage'])) {
            return $this->appPaths['storage'];
        }
        return $this->basePath.'/storage';
    }

    /**
     * Get the path to the storage directory.
     *
     * @return string
     */
    public function storageSessionPath()
    {
        if (isset($this->appPaths['storageSession'])) {
            
            $this->instance('storage.session', $this->appPaths['storageSession']);
            
            return $this->appPaths['storageSession'];
        }
        
        return $this->basePath.'/storage/framework/session';
        
    }
}