<?php

declare(strict_types=1);

namespace App\Application\UseCases\Auth;

use App\Application\Exceptions\BusinessException;
use App\Domain\Services\AuthServiceInterface;

class CheckAuthenticationUseCase
{
    public function __construct(
        protected AuthServiceInterface $authService
    ) {
    }

    /**
     * @throws BusinessException
     */
    public function execute(): void
    {
        $isUnauthorized = ! $this->authService->validateToken();

        if ($isUnauthorized) {
            throw new BusinessException('Unauthorized');
        }
    }
}
