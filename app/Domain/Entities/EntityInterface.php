<?php

namespace App\Domain\Entities;

use Carbon\Carbon;

interface EntityInterface
{
    public function setCreatedAt(Carbon $dateTime): void;

    public function setUpdatedAt(?Carbon $dateTime): void;

    public function toArray(): array;

    public static function fromArray(array $parameters): ?static;
}
