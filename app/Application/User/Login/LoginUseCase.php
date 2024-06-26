<?php

declare(strict_types=1);

namespace App\Application\User\Login;

use App\Application\Shared\Exception\BusinessException;
use App\Domain\User\Service\AuthServiceInterface;

class LoginUseCase
{
    public function __construct(
        protected AuthServiceInterface $authService
    ) {
    }

    public function execute(LoginInputDTO $input): LoginOutputDTO
    {
        $email = $input->email;
        $password = $input->password;

        $this->validateCredentials($email, $password);

        $token = $this->generateToken($email, $password);

        return new LoginOutputDTO(['token' => $token]);
    }

    /**
     * @throws BusinessException
     */
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
