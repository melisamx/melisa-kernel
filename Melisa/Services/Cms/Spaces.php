<?php

namespace Melisa\Services\Cms;

use Melisa\Resource;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class Spaces extends Resource
{
    
    protected $languages = [];

    public function __construct($service)
    {
        parent::__construct($service);
        $this->serviceName = 'spaces';
        $this->methods = [
            'all'=>[
                'path'=>'spaces',
                'method'=>'GET',
            ],
            'import'=>[
                'path'=>'spaces/import',
                'method'=>'POST',
            ]
        ];
    }
    
    public function addLanguage($keyLanguage, $isDefault = 0)
    {
        $this->languages []= [
            'key'=>$keyLanguage,
            'isDefault'=>$isDefault
        ];
        return $this;
    }
    
    public function import($name, $key = null)
    {
        $params = [
            'parameters'=>[
                'name'=>$name,
                'key'=>is_null($key) ? str_slug($name) : $key,
            ]
        ];
        
        if (!empty($this->languages)) {
            $params ['parameters']['languages']= $this->languages;
            $this->languages = [];
        }
        
        return $this->call('import', [$params]);
    }
    
    public function all($limit = 50, $start = 1, $page = 1)
    {
        $params = [
            'parameters'=>[
                'page'=>$page,
                'start'=>$start,
                'limit'=>$limit
            ]
        ];
        return $this->call('all', [$params]);
    }
    
}
