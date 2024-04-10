<?php

declare(strict_types=1);

namespace App\Application\Helpers;

interface UuidGeneratorInterface
{
    public function generateUuid(): string;
}
