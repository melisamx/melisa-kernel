<?php

namespace Melisa\core;
use Melisa\core\Base;

/* 
 * Loader libraries, logics and views
 * 
 */
class Loader extends Base
{
    
    public function libraries($library, $params =NULL) {
        
        return loader($library, 'libraries', $params);
        
    }
    
    public function logic($logic, $path = '') {
        
        return loader($logic, 'logics/' . $path);
        
    }
    
    public function paging(&$output) {
        
        $this->getApp()->afterAction();
        $ci = &get_instance();
        
        $ci->load->view('response_json_paging', [
            'output'=>$output,
            'response'=>$this->getApp()->output()->get(),
            'bm'=>$ci->abs->config_get('app.benchmark')
        ]);
        
    }
    
    public function simple(&$output) {
        
        $this->getApp()->afterAction();        
        $ci = &get_instance();
        
        $ci->load->view('response_json_simple', [
            'output'=>$output,
            'response'=>$this->getApp()->output()->get(),
            'bm'=>$ci->abs->config_get('app.benchmark')
        ]);
        
    }
    
    public function success(&$output) {
        
        $this->getApp()->afterAction();
        
        $ci = &get_instance();
        
        $ci->load->view('response_json_agregar', [
            'output'=>$output,
            'response'=>$this->getApp()->output()->get(),
            'bm'=>$ci->abs->config_get('app.benchmark')
        ]);
        
    }
    
    public function create(&$output) {
        
        $this->getApp()->afterAction();
        $ci = &get_instance();
        
        $ci->load->view('response_json_agregar', [
            'output'=>$output,
            'response'=>$this->getApp()->output()->get(),
            'bm'=>$ci->abs->config_get('app.benchmark')
        ]);
        
    }
    
}
