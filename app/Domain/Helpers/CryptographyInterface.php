<?php

namespace App\Domain\Helpers;

interface CryptographyInterface
{
    public function create(string $value): string;

    public function compare(string $hash, string $value): bool;
}
