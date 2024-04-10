<?php

declare(strict_types=1);

namespace App\Infrastructure\Services\Logger;

use App\Domain\Shared\Service\LoggerInterface;
use Illuminate\Support\Facades\Log;

class LoggerService implements LoggerInterface
{
    public function error(string $message, ?array $context = []): void
    {
        Log::error($message, $context);
    }

    public function info(string $message, ?array $context = []): void
    {
        Log::info($message, $context);
    }

    public function warning(string $message, ?array $context = []): void
    {
        Log::error($message, $context);
    }

    public function debug(string $message, ?array $context = []): void
    {
        Log::error($message, $context);
    }
}
