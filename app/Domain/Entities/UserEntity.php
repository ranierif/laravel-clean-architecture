<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use Carbon\Carbon;

class UserEntity extends EntityAbstract
{
    public function __construct(
        private ?int $id,
        private string $name,
        private string $email,
        private ?string $phone_number,
        private ?string $password,
        private ?Carbon $created_at = null,
        private ?Carbon $updated_at = null,
        private ?Carbon $deleted_at = null
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function toArray(?array $attributes = null): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'phone_number' => $this->getPhoneNumber(),
            'password' => $this->getPassword(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
            'deleted_at' => $this->getDeletedAt(),
        ];
    }
}
