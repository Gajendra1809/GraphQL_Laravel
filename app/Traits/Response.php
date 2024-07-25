<?php

namespace App\Traits;

trait Response
{
     protected function success($data = [], $message = null){
        return [
            'success' => true,
            'message' => $message,
            'data' => $data
        ];
     }

     protected function error($message, $code){
        return [
            'success' => false,
            'message' => 'Something is wrong!',
            'error' => [
                'message' => $message,
                'code' => $code
            ]
        ];
     }
}