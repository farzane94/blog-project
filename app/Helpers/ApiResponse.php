<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class ApiResponse
{
    public static function success(mixed $data = [], int $status = 200): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'server_time' => Carbon::now()->toDateTimeString(),
        ], $status);
    }

    public static function error(string $message, int $status = 400, array $errors = []): JsonResponse
    {
        return response()->json([
            'data' => [
                'message' => $message,
                'errors' => $errors
            ],
            'server_time' => Carbon::now()->toDateTimeString(),
        ], $status);
    }
}
