<?php

declare(strict_types=1);

namespace App\Infrastructure\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class HttpException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'statusCode' => $this->getCode(),
            'message' => $this->getMessage(),
        ], $this->getCode());
    }
}
