<?php

namespace App\Infrastructure\Helpers;

use Illuminate\Http\JsonResponse;

/**
 * @codeCoverageIgnore
 */
class BaseResponse
{
    public static function success($message, $statusCode): JsonResponse
    {
        $response = [
            'statusCode' => $statusCode,
            'message' => $message,
        ];

        return response()->json($response, $statusCode);
    }

    public static function successWithContent($message, int $statusCode, $content): JsonResponse
    {
        $body = [
            'statusCode' => $statusCode,
            'message' => $message,
            'content' => $content,
        ];

        return response()->json($body, $statusCode);
    }
}
