<?php

namespace Melisa\Services\Cms;

use Melisa\Resource;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class ContentTypes extends Resource
{
    
    protected $fields = [];

    public function __construct($service)
    {
        parent::__construct($service);
        $this->serviceName = 'contentTypes';
        $this->methods = [
            'import'=>[
                'path'=>'spaces/{spaceKey}/contentTypes/import',
                'method'=>'POST',
            ],
        ];
    }
    
    public function addField($name, $key, $type, $metadata = [])
    {
        $metadataSubmit = [];
        foreach($metadata as $k=>$value) {
            $metadataSubmit []= [
                'key'=>$k,
                'value'=>$value
            ];
        }
        $this->fields []= [
            'name'=>$name,
            'key'=>$key,
            'type'=>$type,
            'metadata'=>$metadataSubmit
        ];
        return $this;
    }
    
    public function importJson($spaceKey, $json)
    {
        $params = [
            'parametersUrl'=>[
                'spaceKey'=>$spaceKey,
            ],
            'parameters'=>$json
        ];
        $this->fields = [];
        return $this->call('import', [$params]);
    }
    
    public function import($spaceKey, $name, $key, $displayTemplate = null, $description = null)
    {
        $params = [
            'parametersUrl'=>[
                'spaceKey'=>$spaceKey,
            ],
            'parameters'=>[                
                'name'=>$name,
                'key'=>$key,
                'displayTemplate'=>$displayTemplate,
                'description'=>!is_null($description) ? $description : 'Sin descripción',
                'fields'=>$this->fields
            ]
        ];
        $this->fields = [];
        return $this->call('import', [$params]);
    }
    
}
