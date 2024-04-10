<?php

namespace App\Infrastructure\Providers;

use App\Application\Helpers\CryptographyInterface;
use App\Application\Helpers\UuidGeneratorInterface;
use App\Infrastructure\Helpers\Cryptography;
use App\Infrastructure\Helpers\UuidGenerator;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CryptographyInterface::class, Cryptography::class);
        $this->app->bind(UuidGeneratorInterface::class, UuidGenerator::class);
    }
}
