<?php 

namespace App\API;

class ApiMessages
{
    public static function responseMessage($message, $code)
    {
        return [
            'message' => $message,
            'code' => $code
        ];
    }
}