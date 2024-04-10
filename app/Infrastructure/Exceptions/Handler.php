<?php

namespace App\Infrastructure\Exceptions;

use App\Domain\Enums\HttpCode;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthenticationException) {
            throw new HttpException('Unauthorized', HttpCode::UNAUTHORIZED);
        }

        return parent::render($request, $exception);
    }
}
