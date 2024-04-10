<?php

declare(strict_types=1);

namespace App\Application\Helpers;

interface CryptographyInterface
{
    public function create(string $value): string;

    public function compare(string $hash, string $value): bool;
}
