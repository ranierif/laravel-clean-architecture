<?php

namespace App\Infrastructure\Providers;

use App\Domain\Shared\Service\LoggerInterface;
use App\Domain\User\Service\AuthServiceInterface;
use App\Infrastructure\Services\AuthService\JwtAuthService;
use App\Infrastructure\Services\Logger\LoggerService;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AuthServiceInterface::class, JwtAuthService::class);
        $this->app->bind(LoggerInterface::class, LoggerService::class);
    }
}
