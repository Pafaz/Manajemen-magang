<?php

namespace App\Helpers;

use Illuminate\Http\Response;

class Api
{
    public static function response( $data, string $message, int $statusCode = Response::HTTP_OK, array $meta = [],$status = 'success')
    {
        if ($statusCode >= 400) {
            $status = 'error';
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'meta' => array_merge(['code' => $statusCode], $meta)
        ], $statusCode);
    }
}