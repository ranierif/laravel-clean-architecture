<?php

$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

$app->useAppPath(realpath(__DIR__.'/../app/Infrastructure'));

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    \App\Infrastructure\Http\Kernel::class,
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    \App\Infrastructure\Console\Kernel::class,
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    \App\Infrastructure\Exceptions\Handler::class
);

return $app;
