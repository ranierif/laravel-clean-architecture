<?php

declare(strict_types=1);

namespace App\Domain\Services;

interface AuthServiceInterface
{
    public function generateToken(string $email, string $password): ?string;

    public function validateCredentials(array $input): bool;

    public function validateToken(): bool;

    public function logout(): void;
}
