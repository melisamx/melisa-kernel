<?php 

namespace Melisa\ci;

/**
 * 
 * @version 1.0
 * @author Luis Josafat Heredia Contreras
 * 
 */
class Loader extends \CI_Loader
{
    
    public function __construct() {
        
        parent::__construct();
        $this->_ci_library_paths[]= MYCORE;
        $this->_ci_model_paths = [
            APPPATH,
            MYAPPCORE,
            MYCORE
        ];
        $this->_ci_helper_paths[] = MYCORE;
        $this->_ci_view_paths = array(
            APPPATH . 'views/'=>TRUE,
            MYAPPCORE . 'views/'=>TRUE,
            MYCORE . 'views/'=>TRUE
        );
        
    }
    
    /**
     * Permite extender la libreria driver cache file
     *
     * @param	string	the name of the class
     * @param	mixed	the optional parameters
     * @param	string	an optional object name
     * @return	void
     */
    public function driver($library = '', $params = NULL, $object_name = NULL)
    {
        
        $subclassPrefix = config_item('subclass_prefix');
        
        /* buscamos si ya se cargo la subclase */
        if ( ! class_exists($subclassPrefix.'Driver_Library')) {
            
            $file = APPPATH.'libraries/'.$subclassPrefix.'Driver.php';
            
            if (is_file($file)) {
                
                // we aren't instantiating an object here, that'll be done by the Library itself
                require $file;
                
            } else {
                
                /* obtenemos el driver CI */
                if ( !class_exists('CI_Driver_Library'))
                {
                    
                    // we aren't instantiating an object here, that'll be done by the Library itself
                    require BASEPATH.'libraries/Driver.php';

                }
                
            }
            
        }

        if ($library == '') {
            
            return FALSE;
            
        }

        // We can save the loader some time since Drivers will *always* be in a subfolder,
        // and typically identically named to the library
        if ( ! strpos($library, '/')) {
            
            $library = ucfirst($library).'/'.$library;
            
        }
        
        return $this->library($library, $params, $object_name);
        
    }
    
    /**
	 * Internal CI Library Loader
	 *
	 * @used-by	CI_Loader::library()
	 * @uses	CI_Loader::_ci_init_library()
	 *
	 * @param	string	$class		Class name to load
	 * @param	mixed	$params		Optional parameters to pass to the class constructor
	 * @param	string	$object_name	Optional object name to assign to
	 * @return	void
	 */
	protected function _ci_load_library($class, $params = NULL, $object_name = NULL)
	{
        
//        if($class === 'Myapp') {
//            
//            return parent::_ci_load_library($class, $params, $object_name);
//            
//        }
        
		// Get the class name, and while we're at it trim any slashes.
		// The directory path can be included as part of the class name,
		// but we don't want a leading slash
		$class = str_replace('.php', '', trim($class, '/'));
        
		// Was the path included with the class name?
		// We look for a slash to determine this
		if (($last_slash = strrpos($class, '/')) !== FALSE)
		{
			// Extract the path
			$subdir = substr($class, 0, ++$last_slash);

			// Get the filename from the path
			$class = substr($class, $last_slash);
		}
		else
		{
			$subdir = '';
		}
        
		$class = ucfirst($class);

		// Is this a stock library? There are a few special conditions if so ...
		if (file_exists(BASEPATH.'libraries/'.$subdir.$class.'.php'))
		{
			return $this->_ci_load_stock_library($class, $subdir, $params, $object_name);
		}

		// Let's search for the requested library file and load it.
		foreach ($this->_ci_library_paths as $path)
		{
			// BASEPATH has already been checked for
			if ($path === BASEPATH)
			{
				continue;
			}

			$filepath = $path.'libraries/'.$subdir.$class.'.php';

			// Safety: Was the class already loaded by a previous call?
			if (class_exists($class, FALSE))
			{
				// Before we deem this to be a duplicate request, let's see
				// if a custom object name is being supplied. If so, we'll
				// return a new instance of the object
				if ($object_name !== NULL)
				{
					$CI =& get_instance();
					if ( ! isset($CI->$object_name))
					{
						return $this->_ci_init_library($class, '', $params, $object_name);
					}
				}

				logger()->debug( $class.' class already loaded. Second attempt ignored.');
				return;
			}
			// Does the file exist? No? Bummer...
			elseif ( ! file_exists($filepath))
			{
				continue;
			}
            
			include_once($filepath);
			return $this->_ci_init_library($class, '', $params, $object_name, $subdir);
		}

		// One last attempt. Maybe the library is in a subdirectory, but it wasn't specified?
		if ($subdir === '')
		{
			return $this->_ci_load_library($class.'/'.$class, $params, $object_name);
		}

		// If we got this far we were unable to find the requested class.
		log_message('error', 'Unable to load the requested class: '.$class);
		show_error('Unable to load the requested class: '.$class);
	}
    
    /**
	 * Internal CI Library Instantiator
	 *
	 * @used-by	CI_Loader::_ci_load_stock_library()
	 * @used-by	CI_Loader::_ci_load_library()
	 *
	 * @param	string		$class		Class name
	 * @param	string		$prefix		Class name prefix
	 * @param	array|null|bool	$config		Optional configuration to pass to the class constructor:
	 *						FALSE to skip;
	 *						NULL to search in config paths;
	 *						array containing configuration data
	 * @param	string		$object_name	Optional object name to assign to
	 * @return	void
	 */
	protected function _ci_init_library($class, $prefix, $config = FALSE, $object_name = NULL, $namespace = '')
	{
        
//        if( $class === 'Myapp') {
//            
//            return parent::_ci_init_library($class, $prefix, $config, $object_name);
//            
//        }
        
		// Is there an associated config file for this class? Note: these should always be lowercase
		if ($config === NULL)
		{
			// Fetch the config paths containing any package paths
			$config_component = $this->_ci_get_component('config');

			if (is_array($config_component->_config_paths))
			{
				$found = FALSE;
				foreach ($config_component->_config_paths as $path)
				{
					// We test for both uppercase and lowercase, for servers that
					// are case-sensitive with regard to file names. Load global first,
					// override with environment next
					if (file_exists($path.'config/'.strtolower($class).'.php'))
					{
						include($path.'config/'.strtolower($class).'.php');
						$found = TRUE;
					}
					elseif (file_exists($path.'config/'.ucfirst(strtolower($class)).'.php'))
					{
						include($path.'config/'.ucfirst(strtolower($class)).'.php');
						$found = TRUE;
					}

					if (file_exists($path.'config/'.ENVIRONMENT.'/'.strtolower($class).'.php'))
					{
						include($path.'config/'.ENVIRONMENT.'/'.strtolower($class).'.php');
						$found = TRUE;
					}
					elseif (file_exists($path.'config/'.ENVIRONMENT.'/'.ucfirst(strtolower($class)).'.php'))
					{
						include($path.'config/'.ENVIRONMENT.'/'.ucfirst(strtolower($class)).'.php');
						$found = TRUE;
					}

					// Break on the first found configuration, thus package
					// files are not overridden by default paths
					if ($found === TRUE)
					{
						break;
					}
				}
			}
		}
        
		$class_name = $prefix.$class;
        
        // suport namespaces
        $classNamespace = str_replace('/', '\\', $namespace) . $class_name;
        
		// Is the class name valid?
		if ( ! class_exists($class_name, FALSE))
		{
            
            if(!class_exists($classNamespace, FALSE)) {
                
                log_message('error', 'Non-existent class: '.$class_name);
                show_error('Non-existent class: '.$class_name);
                
            }
            
		}
        
		// Set the variable name we will assign the class to
		// Was a custom class name supplied? If so we'll use it
		if (empty($object_name))
		{
			$object_name = strtolower($class);
			if (isset($this->_ci_varmap[$object_name]))
			{
				$object_name = $this->_ci_varmap[$object_name];
			}
		}

		// Don't overwrite existing properties
		$CI =& get_instance();
        
		if (isset($CI->$object_name))
		{
			if ($CI->$object_name instanceof $class_name)
			{
				log_message('debug', $class_name." has already been instantiated as '".$object_name."'. Second attempt aborted.");
				return;
			}

			show_error("Resource '".$object_name."' already exists and is not a ".$class_name." instance.");
		}

		// Save the class name and object name
		$this->_ci_classes[$object_name] = $class;
        
        if ( class_exists($class_name, FALSE)) {
            
            // Instantiate the class
            $CI->$object_name = isset($config)
                ? new $class_name($config)
                : new $class_name();
            
            return;
            
        }
        
		// Instantiate the class
		$CI->$object_name = isset($config)
			? new $classNamespace($config)
			: new $classNamespace();
        
	}
    
}
