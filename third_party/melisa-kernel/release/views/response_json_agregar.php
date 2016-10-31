<?php 

/* comprobamos el resultado */
if( !$output) {
    
    if( defined('HEADER_ERROR_400') && !HEADER_ERROR_400) {
         
         get_instance()->output->set_status_header(400);
         
    }
    
    $mensajes = message();
    
    /* benchmark */
    if($bm) echo json_encode(array_default($mensajes, array(
        'ok'=>0,
        'success'=>FALSE,
        'bm'=>array(
            't'=>'{elapsed_time}',
            'm'=>'{memory_usage}'
        )
    )));
    else echo json_encode(array_default($mensajes, array(
        'ok'=>0,
        'success'=>FALSE
    )));

} else {

    /* benchmark */
    if($bm) {
        
        /* verify response */
        if( isset($response)) echo json_encode(array_default($response, array(
            'ok'=>1,
            'success'=>TRUE,
            'id'=>$output,
            'bm'=>array(
                't'=>'{elapsed_time}',
                'm'=>'{memory_usage}'
            )
        )));
        else  echo json_encode(array(
            'ok'=>1,
            'success'=>TRUE,
            'id'=>$output,
            'bm'=>array(
                't'=>'{elapsed_time}',
                'm'=>'{memory_usage}'
            )
        ));
    } else {
        
        /* verify response */
        if( isset($response)) echo json_encode(array_default($response, array(
            'ok'=>1,
            'id'=>$output,
            'success'=>TRUE
        )));
        else echo json_encode(array(
            'ok'=>1,
            'id'=>$output,
            'success'=>TRUE
        ));
        
    }

}
