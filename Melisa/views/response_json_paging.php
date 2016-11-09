<?php 

get_instance()->abs->output_set_content_type('json');

if( !isset($bm)) {
    
    $bm = TRUE;
    
}

/* verificamos si esta activo mostrar marcas bechmark */
if($output === FALSE) {
    
    if( defined('HEADER_ERROR_400') && !HEADER_ERROR_400) {
         
         get_instance()->output->set_status_header(400);
         
    }
    
    $messages = msg()->get();
    
    if( isset($bm) && $bm) {
        
        echo json_encode(arrayDefault($messages, [
            'ok'=>0,
            'success'=>FALSE,
            'records'=>[],
            'totalActual'=>0,
            'totalRecords'=>0,
            'bm'=>[
                't'=>'{elapsed_time}',
                'm'=>'{memory_usage}'
            ]
        ]));
        
    } else {
        
        echo json_encode(arrayDefault($messages, [
            'success'=>FALSE,
            'records'=>[],
            'totalActual'=>0,
            'totalRecords'=>0
        ]));
        
    }
    
} else {
    
    if( !isset($output['records'])) {
        
        $output = [
            'records'=>[],
            'totalRecords'=>0
        ];
        
    }
    
    if( isset($bm) && $bm) {
        
        echo json_encode([
            'success'=>TRUE,
            'records'=>$output['records'],
            'totalActual'=>count($output['records']),
            'totalRecords'=>$output['totalRecords'],
            'bm'=>array(
                't'=>'{elapsed_time}',
                'm'=>'{memory_usage}'
            )
        ]);
        
    } else {
        
        echo json_encode([
            'success'=>TRUE,
            'records'=>$output['records'],
            'totalActual'=>count($output['records']),
            'totalRecords'=>$output['totalRecords']
        ]);
        
    }
    
}
