<?php 

namespace Melisa\laravel;

/**
 * 
 * Fork laravel events :P
 * @version 1.0
 * @author Luis Josafat Heredia Contreras
 * 
 */
class Events {
    
    /**
	 * All of the registered events.
	 *
	 * @var array
	 */
	protected $varpPhpListeners = array();
    
    /**
     * The sorted event listeners.
     * 
     * @var array
     */
    protected $varpPhpSorted= array();
    
    /**
     * The wildcard listeners.
     * 
     * @var array
     */
    protected $varpPhpWild_cards=array();
    
    /**
     * The event firing stack.
     * 
     * @var array
     */
    protected $varpPhpFiring = array();

	/**
	 * The queued events waiting for flushing.
	 *
	 * @var array
	 */
	public static $varpPhpQueued = array();

	/**
	 * All of the registered queue flusher callbacks.
	 *
	 * @var array
	 */
	public static $varpPhpFlushers = array();
    
	/**
	 * Register an event listener with the dispatcher.
	 *
	 * @param  string  $event
	 * @param  mixed   $listener
     * @param int $varlPhpPri
	 * @return void
	 */
	public function listen($varlPhpEvent, $varlPhpListener, $varlPhpPriority=0) {
        
        if( str_contains($varlPhpEvent, '*')) {
            
            return $this->setupWildcardListen($varlPhpEvent, $varlPhpListener);
            
        }
        
		$this->varpPhpListeners[$varlPhpEvent][$varlPhpPriority][] = $this->makeListener($varlPhpListener);
        
        /* necesario para ordenar nuevamente los eventos */
        unset($this->varpPhpSorted[$varlPhpEvent]);
        
	}
    
     /**
      * Setup a wildcard listener callback.
      * 
      * @param type $event
      * @param type $listener
      */
    protected function setupWildcardListen($varlPhpEvent, $varlPhpListener) {
        
        $this->varpPhpWild_cards[$varlPhpEvent][] = $this->makeListener($varlPhpListener);
        
    }
    
    /**
	 * Determine if a given event has listeners.
	 *
	 * @param  string  $event
	 * @return bool
	 */
	public function hasListeners($varlPhpEvent_name) {
        
		return isset($this->varpPhpListeners[$varlPhpEvent_name]);
        
	}


	/**
	 * override all callbacks for a given event with a new callback.
	 *
	 * @param  string  $event
	 * @param  mixed   $callback
	 * @return void
	 */
	public static function override($varlPhpEvent, $varlPhpCallback)
	{
		static::clear($varlPhpEvent);

		static::listen($varlPhpEvent, $varlPhpCallback);
	}

	/**
	 * Register a queued event and payload.
	 *
	 * @param  string  $varlPhpEvent
	 * @param  array  $varlPhpPayLoad
	 * @return void
	 */
	public function queue($varlPhpEvent, $varlPhpPayLoad=array()) {
        
        $varlPhpMe=$this;
        
        $this->listen($varlPhpEvent.'_queue', function() use ($varlPhpMe, $varlPhpEvent, $varlPhpPayLoad) {
           
            $varlPhpMe->fire($varlPhpEvent, $varlPhpPayLoad);
            
        });
        
	}
    
    /**
     * Register an event subscriber with the dispatcher.
     * 
     * @param type $varlPhpSubscriber
     * @return void
     */
    public function subscribe($varlPhpSubscriber) {
        
        $varlPhpSubscriber = $this->resolveSubscriber($varlPhpSubscriber);

        $varlPhpSubscriber->subscribe($this);
        
    }
    
    /**
     * Resolve the subscriber instance.
     * 
     * @param type $varlPhpSubscriber
     * @return mixed
     * 
     */
    protected function resolveSubscriber($varlPhpSubscriber) {
        
        if (is_string($varlPhpSubscriber)) {
            
            return $this->container->make($varlPhpSubscriber);
            
        }

        return $varlPhpSubscriber;
        
    }

	/**
	 * Register a queue flusher callback.
	 *
	 * @param  string  $queue
	 * @param  mixed   $callback
	 * @return void
	 */
	public static function flusher($varlPhpQueue, $varlPhpCallback)
	{
		static::$varpPhpFlushers[$varlPhpQueue][] = $varlPhpCallback;
	}

	/**
	 * Fire an event until the first non-null response is returned.
	 *
	 * @param  string  $event
	 * @param  array   $varlPhpPayload
	 * @return mixed
	 */
	public function until($varlPhpEvent, $varlPhpPayload = array()) {
        
		return $this->fire($varlPhpEvent, $varlPhpPayload, true);
        
	}

	/**
	 * Flush a set of queued events..
	 *
	 * @param  string  $varlPhpEvent
	 * @return void
	 */
	public function flush($varlPhpEvent) {
        
		$this->fire($varlPhpEvent.'_queue');
        
	}
    
    /**
     * Get the event that is currently firing.
     * 
     * @return string
     * 
     */
    public function firing() {
        
        /* return last($this->firing); */
        /* se obtuvo del archivo */
        /* framework / src / Illuminate / Support / Collection.php */
        /* ya que la funcion last no existe */
        
        return count($this->varpPhpFiring) > 0 ? end($this->varpPhpFiring) : NULL;
    }

	/**
	 * Fire an event and call the listeners.
	 *
	 * @param  string|array  $varlPhpEvent
	 * @param  array         $varlPhpPayload
	 * @param  bool          $varlPhpHalt
	 * @return array|null
	 */
	public function fire($varlPhpEvent, $varlPhpPayload=array(), $varlPhpHalt=FALSE) {
        
        /* respuestas */
		$varlPhpResponses = array();
        
        // If an array is not given to us as the payload, we will turn it into one so
        // we can easily use call_user_func_array on the listeners, passing in the
        // payload to each of them so that they receive each of these arguments.
        if( !is_array($varlPhpPayload)) {
            
            $varlPhpPayload = array($varlPhpPayload);
            
        }
        
        $this->varpPhpFiring[] = $varlPhpEvent;

		// If the event has listeners, we will simply iterate through them and call
		// each listener, passing in the parameters. We will add the responses to
		// an array of event responses and return the array.
		foreach ($this->getListeners($varlPhpEvent) as $varlPhpListener) {
            
			$varlPhpResponse = call_user_func_array($varlPhpListener, $varlPhpPayload);

            // If a response is returned from the listener and event halting is enabled
            // we will just return this response, and not call the rest of the event
            // listeners. Otherwise we will add the response on the response list.
            if ( ! is_null($varlPhpResponse) && $varlPhpHalt) {
                
                array_pop($this->varpPhpFiring);

                return $varlPhpResponse;
                
            }
            
            // If a boolean false is returned from a listener, we will stop propagating
            // the event to any further listeners down in the chain, else we keep on
            // looping through the listeners and firing every one in our sequence.
            $varlPhpResponses[] = $varlPhpResponse;
            
            if ($varlPhpResponse === FALSE) {
                
                break;
                
            }
            
		}
        
        array_pop($this->varpPhpFiring);

		return $varlPhpHalt ? NULL : $varlPhpResponses;
        
	}
    
    /**
     * Get all of the listeners for a given event name.
     * 
     * @param type $varlPhpEvent_name
     * @return array
     * 
     */
    public function getListeners($varlPhpEvent_name) {
        
        $varlPhpWildcards = $this->getWildcardListeners($varlPhpEvent_name);
        
        if( !isset($this->varpPhpSorted[$varlPhpEvent_name])) {
            
            $this->sortListeners($varlPhpEvent_name);
            
        }
        
        return array_merge($this->varpPhpSorted[$varlPhpEvent_name], $varlPhpWildcards);
        
    }
    
    /**
     * Get the wildcard listeners for the event.
     * 
     * @param type $varlPhpEventName
     * @return array
     */
    protected function getWildcardListeners($varlPhpEventName) {
        
        $varlPhpWildcards = array();

        foreach ($this->varpPhpWild_cards as $varlPhpKey => $varlPhpListeners) {

            if (str_is($varlPhpKey, $varlPhpEventName)) $varlPhpWildcards = array_merge($varlPhpWildcards, $varlPhpListeners);

        }

        return $varlPhpWildcards;
        
    }
    
    /**
     * Sort the listeners for a given event by priority.
     * 
     * @param type $varlPhpEvent_name
     * @return type
     */
    private function sortListeners($varlPhpEvent_name) {
        
        /* init event order */
        $this->varpPhpSorted[$varlPhpEvent_name]=array();
        
        // If listeners exist for the given event, we will sort them by the priority
        // so that we can call them in the correct order. We will cache off these
        // sorted event listeners so we do not have to re-sort on every events.
        
        if(isset($this->varpPhpListeners[$varlPhpEvent_name])) {
            
            krsort($this->varpPhpListeners[$varlPhpEvent_name]);

            $this->varpPhpSorted[$varlPhpEvent_name] = call_user_func_array('array_merge', $this->varpPhpListeners[$varlPhpEvent_name]);
                        
        }
        
    }    
    
    /**
     * Register an event listener with the dispatcher.
     * 
     * @param type $listener
     * @return mixed
     */
    public function makeListener($varlPhpListener) {
        
        if (is_string($varlPhpListener)) {
            
                $varlPhpListener = $this->createClassListener($varlPhpListener);
        }

        return $varlPhpListener;
    }
    
    public function forget($varlPhpEvent) {
        
        unset($this->varpPhpListeners[$varlPhpEvent]);

        unset($this->varpPhpSorted[$varlPhpEvent]);
        
    }
    
}