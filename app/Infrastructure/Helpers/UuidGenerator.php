<?php

namespace App\Infrastructure\Helpers;

use App\Application\Helpers\UuidGeneratorInterface;
use Illuminate\Support\Str;

class UuidGenerator implements UuidGeneratorInterface
{
    public function generateUuid(): string
    {
        return Str::uuid()->toString();
    }
}
