<?php

declare(strict_types=1);

namespace App\Application\User\Logout;

use App\Domain\User\Service\AuthServiceInterface;
use Throwable;

class LogoutUseCase
{
    public function __construct(
        protected AuthServiceInterface $authService
    ) {
    }

    /**
     * @throws Throwable
     */
    public function execute(): void
    {
        $this->authService->logout();
    }
}
