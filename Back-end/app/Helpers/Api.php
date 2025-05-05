<?php

namespace App\Helpers;

use Illuminate\Http\Response;

class Api
{
    public static function response($data, string $message, int $statusCode = Response::HTTP_OK, array $meta = [], ?string $status = null)
    {
        $status ??= $statusCode >= 400 ? 'error' : 'success';

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'meta' => array_merge(['code' => $statusCode], $meta)
        ], $statusCode);
    }
}