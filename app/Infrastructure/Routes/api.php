<?php

use App\Infrastructure\Http\Controllers\Auth\LoginController;
use App\Infrastructure\Http\Controllers\Auth\LogoutController;
use App\Infrastructure\Http\Controllers\Cart\CreateCartController;
use App\Infrastructure\Http\Controllers\Cart\GetCartController;
use App\Infrastructure\Http\Controllers\Cart\PayCartController;
use App\Infrastructure\Http\Controllers\User\CreateUserController;
use App\Infrastructure\Http\Controllers\User\GetUserController;
use Illuminate\Support\Facades\Route;
use Spatie\Health\Http\Controllers\HealthCheckJsonResultsController;

Route::get('health', HealthCheckJsonResultsController::class);

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', LoginController::class);
    });

    Route::prefix('user')->group(function () {
        Route::post('create', CreateUserController::class);
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::prefix('auth')->group(function () {
            Route::post('/logout', LogoutController::class);
        });

        Route::prefix('user')->group(function () {
            Route::get('get', GetUserController::class);
        });

        Route::prefix('cart')->group(function () {
            Route::post('/', CreateCartController::class);
            Route::get('/{uuid}', GetCartController::class);
            Route::post('/{uuid}/pay', PayCartController::class);
        });
    });
});
