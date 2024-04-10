<?php

declare(strict_types=1);

namespace App\Infrastructure\Helpers;

use App\Domain\Shared\Helper\UuidGeneratorInterface;
use Illuminate\Support\Str;

class UuidGenerator implements UuidGeneratorInterface
{
    public function generateUuid(): string
    {
        return Str::uuid()->toString();
    }
}
