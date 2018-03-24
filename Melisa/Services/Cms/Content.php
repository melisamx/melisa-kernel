<?php

namespace Melisa\Services\Cms;

use Melisa\Resource;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
class Content extends Resource
{
    
    protected $filters = [];

    public function __construct($service)
    {
        parent::__construct($service);
        $this->serviceName = 'content';
        $this->methods = [
            'get'=>[
                'path'=>'spaces/{idSpace}/content',
                'method'=>'GET',
            ],
            'getByKey'=>[
                'path'=>'spaces/{keySpace}/content-key',
                'method'=>'GET',
            ],
            'import'=>[
                'path'=>'spaces/{keySpace}/contentTypes/{keyContentType}',
                'method'=>'POST',
            ],
            'delete'=>[
                'path'=>'spaces/{keySpace}/content/{idContent}',
                'method'=>'DELETE',
            ],
            'deleteBySpaceKey'=>[
                'path'=>'spaces/{keySpace}/content/all',
                'method'=>'DELETE',
            ],
        ];
    }
    
    public function deleteBySpaceKey($keySpace)
    {
        $params = [
            'parametersUrl'=>[
                'keySpace'=>$keySpace
            ]
        ];
        
        return $this->call('deleteBySpaceKey', [$params]);
    }
    
    public function delete($keySpace, $idContent)
    {
        $params = [
            'parametersUrl'=>[
                'keySpace'=>$keySpace,
                'idContent'=>$idContent,
            ]
        ];
        
        return $this->call('delete', [$params]);
    }
    
    public function import($keySpace, $keyContentType, array $fields)
    {
        $params = [
            'parametersUrl'=>[
                'keySpace'=>$keySpace,
                'keyContentType'=>$keyContentType,
            ],
            'parameters'=>$fields
        ];
        
        return $this->call('import', [$params]);
    }
    
    public function addFilter($field, $value, $operator = '=')
    {
        $this->filters []= [
            'property'=>$field,
            'value'=>$value,
            'operator'=>$operator
        ];
        return $this;
    }
    
    public function getByKey($keySpace, array $paging = [])
    {
        $defaultPaging = array_merge([
            'page'=>1,
            'start'=>1,
            'limit'=>50
        ], $paging);
        
        $defaulFilters = [
            'filter'=>[]
        ];
        if (!empty($this->filters)) {
            $defaulFilters ['filter']= json_encode($this->filters);
        } else {
            $defaulFilters = [];
        }
        
        $params = [
            'parametersUrl'=>[
                'keySpace'=>$keySpace,
            ],
            'parameters'=>array_merge($defaultPaging, $defaulFilters)
        ];
        $this->filters = [];
        return $this->call('getByKey', [ $params ]);
    }
    
    public function get($idSpace, array $paging = [])
    {
        $defaultPaging = array_merge([
            'page'=>50,
            'start'=>1,
            'limit'=>1
        ], $paging);
        
        $params = [
            'parametersUrl'=>[
                'idSpace'=>$idSpace,
            ],
            'parameters'=>array_merge($defaultPaging, $filters)
        ];
        return $this->call('get', [$params]);
    }
    
}
