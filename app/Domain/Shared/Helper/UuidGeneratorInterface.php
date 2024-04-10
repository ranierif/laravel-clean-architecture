<?php

declare(strict_types=1);

namespace App\Domain\Shared\Helper;

interface UuidGeneratorInterface
{
    public function generateUuid(): string;
}
