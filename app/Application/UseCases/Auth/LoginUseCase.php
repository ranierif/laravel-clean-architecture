<?php

declare(strict_types=1);

namespace App\Application\UseCases\Auth;

use App\Application\DTO\Auth\LoginInputDTO;
use App\Application\DTO\Auth\LoginOutputDTO;
use App\Application\Exceptions\BusinessException;
use App\Domain\Services\AuthServiceInterface;

class LoginUseCase
{
    public function __construct(
        protected AuthServiceInterface $authService
    ) {
    }

    /**
     * @throws BusinessException
     */
    public function execute(LoginInputDTO $input): LoginOutputDTO
    {
        $email = $input->email;
        $password = $input->password;

        $this->validateCredentials($email, $password);

        $token = $this->generateToken($email, $password);

        return new LoginOutputDTO(['token' => $token]);
    }

    protected function validateCredentials(string $email, string $password): void
    {
        $credentials = [
            'email' => $email,
            'password' => $password,
        ];

        $isInvalid = ! $this->authService->validateCredentials($credentials);

        if ($isInvalid) {
            throw new BusinessException('Invalid credentials');
        }
    }

    protected function generateToken(string $email, string $password): ?string
    {
        return $this->authService
            ->generateToken(
                $email,
                $password
            );
    }
}
