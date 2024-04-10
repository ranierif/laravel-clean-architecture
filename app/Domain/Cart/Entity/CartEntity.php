<?php

declare(strict_types=1);

namespace App\Domain\Cart\Entity;

use App\Domain\Shared\Entity\EntityAbstract;
use Carbon\Carbon;

class CartEntity extends EntityAbstract
{
    public function __construct(
        private ?string $uuid,
        private int $user_id,
        private array $items,
        private ?string $status,
        private ?Carbon $approved_at = null,
    ) {
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getApprovedAt(): ?Carbon
    {
        return $this->approved_at ?? null;
    }

    public function toArray(?array $attributes = null): array
    {
        return [
            'id' => $this->getId(),
            'uuid' => $this->getUuid(),
            'user_id' => $this->getUserId(),
            'items' => $this->getItems(),
            'status' => $this->getStatus(),
            'approved_at' => $this->getApprovedAt(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
            'deleted_at' => $this->getDeletedAt(),
        ];
    }
}
