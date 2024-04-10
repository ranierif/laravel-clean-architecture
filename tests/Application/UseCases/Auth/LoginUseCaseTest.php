<?php

declare(strict_types=1);

namespace Tests\Application\UseCases\Auth;

use App\Application\DTO\Auth\LoginInputDTO;
use App\Application\DTO\Auth\LoginOutputDTO;
use App\Application\Exceptions\BusinessException;
use App\Application\UseCases\Auth\LoginUseCase;
use App\Domain\User\Service\AuthServiceInterface;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class LoginUseCaseTest extends TestCase
{
    private AuthServiceInterface|MockInterface $authServiceMock;

    private LoginUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authServiceMock = $this->createMock(AuthServiceInterface::class);

        $this->useCase = new LoginUseCase(
            $this->authServiceMock
        );
    }

    public function test_should_user_login_successfully(): void
    {
        // Arrange
        $input = [
            'email' => 'test@gmail.com',
            'password' => 'Test@20',
        ];

        $this->authServiceMock
            ->expects($this->once())
            ->method('validateCredentials')
            ->willReturn(true);

        $mockToken = 'test-token';

        $this->authServiceMock
            ->expects($this->once())
            ->method('generateToken')
            ->willReturn($mockToken);

        // Act
        $output = $this->useCase
            ->execute(
                new LoginInputDTO([
                    'email' => $input['email'],
                    'password' => $input['password'],
                ])
            );

        // Assert
        $expectedOutput = new LoginOutputDTO([
            'token' => $mockToken,
        ]);

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_should_not_login_with_invalid_credentials(): void
    {
        // Arrange
        $this->expectException(BusinessException::class);
        $this->expectExceptionMessage('Invalid credentials');

        $input = [
            'email' => 'test@gmail.com',
            'password' => 'Test@20',
        ];

        $this->authServiceMock
            ->expects($this->once())
            ->method('validateCredentials')
            ->willReturn(false);

        $this->authServiceMock
            ->expects($this->never())
            ->method('generateToken');

        // Act
        $this->useCase
            ->execute(
                new LoginInputDTO([
                    'email' => $input['email'],
                    'password' => $input['password'],
                ])
            );
    }
}
