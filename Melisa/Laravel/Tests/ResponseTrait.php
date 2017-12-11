<?php

namespace Melisa\Laravel\Tests;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
trait ResponseTrait
{
    
    public function responseRedirect(&$response)
    {
        $response->assertStatus(302);
    }
    
    public function responseWithErrors(&$response, $status = 400)
    {
        $response
            ->assertStatus($status)
            ->assertJson([
                'success'=>false
            ]);
        $json = json_decode($response->getContent());
        $this->assertTrue(isset($json->errors));
        foreach($json->errors as $error) {
            $this->assertTrue(isset($error->message));
        }
    }
    
    public function responseSuccess(&$response)
    {
        $response->assertJson([
            'success'=>true
        ]);
    }
    
    public function responseCreatedSuccess(&$response)
    {
        $response->assertStatus(201);
        $this->responseSuccess($response);
        $json = json_decode($response->getContent());
        $this->assertTrue(isset($json->data));
        $this->assertTrue(isset($json->data->id));
    }
    
    public function responsePagingSuccess(&$response)
    {
        $response->assertStatus(200);
        $this->responseSuccess($response);
        $json = json_decode($response->getContent());
        $this->assertTrue(isset($json->data));
        $this->assertTrue(isset($json->total));
    }
    
    public function responseUnauthenticated($endPoint)
    {
        $response = $this->post($endPoint);
        $this->responseRedirect($response);
        
        $responseAjax = $this
            ->withHeaders([
                'X-Requested-With'=>'XMLHttpRequest'
            ])
            ->post($endPoint);
        
        $this->responseWithErrors($responseAjax, 401);
    }
    
}
