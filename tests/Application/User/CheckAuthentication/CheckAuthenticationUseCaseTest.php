<?php

declare(strict_types=1);

namespace Tests\Application\User\CheckAuthentication;

use App\Application\Shared\Exception\BusinessException;
use App\Application\User\CheckAuthentication\CheckAuthenticationUseCase;
use App\Domain\User\Service\AuthServiceInterface;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class CheckAuthenticationUseCaseTest extends TestCase
{
    private AuthServiceInterface|MockInterface $authServiceMock;

    private CheckAuthenticationUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authServiceMock = $this->createMock(AuthServiceInterface::class);

        $this->useCase = new CheckAuthenticationUseCase(
            $this->authServiceMock
        );
    }

    public function test_should_user_is_authenticated(): void
    {
        // Arrange
        $this->authServiceMock
            ->expects($this->once())
            ->method('validateToken')
            ->willReturn(true);

        // Act
        $this->useCase->execute();
    }

    public function test_should_user_is_unauthenticated(): void
    {
        // Arrange
        $this->expectException(BusinessException::class);
        $this->expectExceptionMessage('Unauthorized');

        $this->authServiceMock
            ->expects($this->once())
            ->method('validateToken')
            ->willReturn(false);

        // Act
        $this->useCase->execute();
    }
}
