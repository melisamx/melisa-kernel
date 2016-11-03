<?php 

if( !$output) {
    
    if( defined('HEADER_ERROR_400') && !HEADER_ERROR_400) {
         
         get_instance()->output->set_status_header(400);
         
    }
    
    $messages = msg()->get();
    
    if($bm) {
        
        echo json_encode(arrayDefault($messages, [
            'success'=>FALSE,
            'bm'=>[
                't'=>'{elapsed_time}',
                'm'=>'{memory_usage}'
            ]
        ]));
        
    } else {
        
        echo json_encode(arrayDefault($messages, [
            'success'=>FALSE
        ]));
        
    }

} else {

    if($bm) {
        
        if( isset($response)) {
            
            echo json_encode(array_default($response, [
                'success'=>TRUE,
                'id'=>$output,
                'bm'=>[
                    't'=>'{elapsed_time}',
                    'm'=>'{memory_usage}'
                ]
            ]));
            
        } else  {
            
            echo json_encode([
                'success'=>TRUE,
                'id'=>$output,
                'bm'=>[
                    't'=>'{elapsed_time}',
                    'm'=>'{memory_usage}'
                ]
            ]);
            
        }
        
    } else {
        
        if( isset($response)) {
            
            echo json_encode(array_default($response, [
                'id'=>$output,
                'success'=>TRUE
            ]));
            
        } else {
            
            echo json_encode([
                'id'=>$output,
                'success'=>TRUE
            ]);
            
        }
        
    }

}
