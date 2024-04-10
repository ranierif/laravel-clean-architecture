<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use Carbon\Carbon;

class PaymentEntity extends EntityAbstract
{
    public function __construct(
        private ?string $uuid,
        private int $user_id,
        private string $cart_uuid,
        private string $method,
        private string $status,
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

    public function getCartUuid(): string
    {
        return $this->cart_uuid;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
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
            'cart_uuid' => $this->getCartUuid(),
            'method' => $this->getMethod(),
            'status' => $this->getStatus(),
            'approved_at' => $this->getApprovedAt(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
            'deleted_at' => $this->getDeletedAt(),
        ];
    }
}
