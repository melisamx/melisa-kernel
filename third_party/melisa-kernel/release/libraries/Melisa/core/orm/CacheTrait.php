<?php

namespace Melisa\core\orm;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait CacheTrait
{
    
    public function cacheDelete(array &$config, &$input) {
        
        if( !$config['cacheDelete']) {
            
            return TRUE;
            
        }
        
        if( !is_array($config['cacheDelete'])) {
            
            $config ['cacheDelete']= [ $config['cacheDelete'] ];
            
        }
        
        foreach ($config['cacheDelete'] as $item) {
            
            if( is_callable($item)) {
                
                $itemCache = call_user_func($item, $input, $config);
                
            } else {
                
                $itemCache = array_interpolate($item, $input);
                
            }
            
            logger()->debug('{c} Delete cache item {i}', [
                'c'=>__CLASS__,
                'i'=>$itemCache
            ]);
            
            cache()->delete($itemCache);
            
        }
        
        return TRUE;
        
    }
    
    public function cacheDeleteRegex(array &$config) {
        
        if( !$config['cacheDeleteRegex']) {
            
            return TRUE;
            
        }
        
        if( !is_array($config['cacheDeleteRegex'])) {
            
            $config['cacheDeleteRegex'] = [ $config['cacheDeleteRegex'] ];
            
        }        
        
        foreach($config['cacheDeleteRegex'] as $item) {
            
            logger()->debug('{c} Delete cache item {i}', [
                'c'=>__CLASS__,
                'i'=>$item
            ]);

            cache()->delete($item, TRUE);
            
        }
        
    }
    
}
