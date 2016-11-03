<?php

namespace Melisa\core;

/**
 * Views auto generate response
 *
 * @author Luis Josafat Heredia Contreras
 */
class Views
{
        
    public function paging(&$output) {
        
        app()->afterAction();
        $ci = &get_instance();
        
        $ci->load->view('response_json_paging', [
            'output'=>$output,
            'response'=>output()->get(),
            'bm'=>$ci->abs->config_get('app.benchmark')
        ]);
        
    }
    
    public function simple(&$output) {
        
        app()->afterAction();        
        $ci = &get_instance();
        
        $ci->load->view('response_json_simple', [
            'output'=>$output,
            'response'=>output()->get(),
            'bm'=>$ci->abs->config_get('app.benchmark')
        ]);
        
    }
    
    public function success(&$output) {
        
        app()->afterAction();
        
        $ci = &get_instance();
        
        $ci->load->view('response_json_agregar', [
            'output'=>$output,
            'response'=>output()->get(),
            'bm'=>$ci->abs->config_get('app.benchmark')
        ]);
        
    }
    
    public function create(&$output) {
        
        app()->afterAction();
        $ci = &get_instance();
        
        $ci->load->view('response_json_agregar', [
            'output'=>$output,
            'response'=>output()->get(),
            'bm'=>$ci->abs->config_get('app.benchmark')
        ]);
        
    }
    
    
}
