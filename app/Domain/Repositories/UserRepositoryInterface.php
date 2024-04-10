<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\EntityInterface;

interface UserRepositoryInterface
{
    public function create(EntityInterface $entity): EntityInterface|\Exception|\Throwable;

    public function findOneBy(string $key, mixed $value): EntityInterface|null|\Exception|\Throwable;

    public function findOneWhere(array $filters): EntityInterface|null|\Exception|\Throwable;

    public function updateOne(EntityInterface $entity, ?array $fields = null): bool|\Exception|\Throwable;
}
