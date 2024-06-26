<?php

declare(strict_types=1);

namespace Tests\Application\User\Logout;

use App\Application\User\Logout\LogoutUseCase;
use App\Domain\User\Service\AuthServiceInterface;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class LogoutUseCaseTest extends TestCase
{
    private AuthServiceInterface|MockInterface $authServiceMock;

    private LogoutUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authServiceMock = $this->createMock(AuthServiceInterface::class);

        $this->useCase = new LogoutUseCase(
            $this->authServiceMock
        );
    }

    public function test_should_user_logout_successfully(): void
    {
        // Arrange
        $this->authServiceMock
            ->expects($this->once())
            ->method('logout')
            ->willReturnSelf();

        // Act
        $this->useCase->execute();
    }
}
