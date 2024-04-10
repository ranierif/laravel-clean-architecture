<?php

declare(strict_types=1);

namespace App\Infrastructure\Helpers;

use App\Domain\Shared\Helper\CryptographyInterface;
use Illuminate\Support\Facades\Hash;

class Cryptography implements CryptographyInterface
{
    public function create(string $value): string
    {
        return Hash::make($value);
    }

    public function compare(string $hash, string $value): bool
    {
        return Hash::check($value, $hash);
    }
}
