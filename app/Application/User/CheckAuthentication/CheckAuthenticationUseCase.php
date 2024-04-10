<?php

declare(strict_types=1);

namespace App\Application\User\CheckAuthentication;

use App\Application\Shared\Exception\BusinessException;
use App\Domain\User\Service\AuthServiceInterface;

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
