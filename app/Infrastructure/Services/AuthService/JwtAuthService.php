<?php

namespace App\Infrastructure\Services\AuthService;

use App\Domain\Services\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;

class JwtAuthService implements AuthServiceInterface
{
    public function generateToken(string $email, string $password): ?string
    {
        return Auth::attempt([
            'email' => $email,
            'password' => $password,
        ]);
    }

    public function validateCredentials(array $input): bool
    {
        return Auth::validate($input);
    }

    public function validateToken(): bool
    {
        return ! empty(Auth::authenticate());
    }

    public function logout(): void
    {
        Auth::logout();
    }
}
