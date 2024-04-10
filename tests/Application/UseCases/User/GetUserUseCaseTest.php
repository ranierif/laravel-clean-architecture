<?php

declare(strict_types=1);

namespace Tests\Application\UseCases\User;

use App\Application\DTO\User\GetUserInputDTO;
use App\Application\DTO\User\GetUserOutputDTO;
use App\Application\UseCases\User\GetUserUseCase;
use App\Domain\Shared\Service\LoggerInterface;
use App\Domain\User\Entity\UserEntity;
use App\Domain\User\Exception\UserNotFoundException;
use App\Domain\User\Service\UserService;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class GetUserUseCaseTest extends TestCase
{
    private UserService|MockInterface $userServiceMock;

    private LoggerInterface|MockInterface $loggerMock;

    private GetUserUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userServiceMock = $this->createMock(UserService::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);

        $this->useCase = new GetUserUseCase(
            $this->userServiceMock,
            $this->loggerMock
        );
    }

    public function test_should_get_user_successfully(): void
    {
        // Arrange
        $userEntity = UserEntity::fromArray([
            'id' => 1,
            'name' => 'Jhon Due',
            'email' => 'test@email.com',
            'phone_number' => '11942421224',
            'password' => 'Test@20',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->userServiceMock
            ->expects($this->once())
            ->method('findOneBy')
            ->willReturn($userEntity);

        // Act
        $useCase = $this->useCase
            ->execute(
                new GetUserInputDTO([
                    'userId' => $userEntity->getId(),
                ])
            );

        // Assert
        $this->assertEquals(
            new GetUserOutputDTO([
                'id' => $userEntity->getId(),
                'name' => $userEntity->getName(),
                'email' => $userEntity->getEmail(),
                'phone_number' => $userEntity->getPhoneNumber(),
            ]),
            $useCase
        );
    }

    public function test_should_not_get_user_when_not_found(): void
    {
        // Arrange
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage('Não foi possível localizar o usuário');

        $userId = 1;

        $this->userServiceMock
            ->expects($this->once())
            ->method('findOneBy')
            ->willThrowException(
                new UserNotFoundException()
            );

        $this->loggerMock
            ->expects($this->once())
            ->method('error');

        // Act
        $this->useCase
            ->execute(
                new GetUserInputDTO([
                    'userId' => $userId,
                ])
            );
    }
}
