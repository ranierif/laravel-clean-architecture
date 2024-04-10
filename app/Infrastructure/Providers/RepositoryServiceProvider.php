<?php

namespace App\Infrastructure\Providers;

use App\Domain\Cart\Repository\CartRepositoryInterface;
use App\Domain\Payment\Repository\PaymentRepositoryInterface;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Infrastructure\Repositories\CartEloquentRepository;
use App\Infrastructure\Repositories\PaymentEloquentRepository;
use App\Infrastructure\Repositories\UserEloquentRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserEloquentRepository::class);
        $this->app->bind(CartRepositoryInterface::class, CartEloquentRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class, PaymentEloquentRepository::class);
    }
}
