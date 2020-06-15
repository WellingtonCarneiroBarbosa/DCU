<?php 

namespace App\API;

class ApiResponses
{
    public static function responseData($data, $code)
    {
        return [
            'data' => $data,
            'code' => $code
        ];
    }

    public static function responseMessage($data, $message, $code)
    {
        return [
            'data' => $data,
            'message' => $message,
            'code' => $code
        ];
    }
}