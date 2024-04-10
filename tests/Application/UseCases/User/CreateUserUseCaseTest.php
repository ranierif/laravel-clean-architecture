<?php

declare(strict_types=1);

namespace Tests\Application\UseCases\User;

use App\Application\DTO\User\CreateUserInputDTO;
use App\Application\UseCases\User\CreateUserUseCase;
use App\Domain\Shared\Service\LoggerInterface;
use App\Domain\User\Entity\UserEntity;
use App\Domain\User\Exception\EmailAlreadyInUseException;
use App\Domain\User\Exception\UserNotCreatedException;
use App\Domain\User\Service\UserService;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class CreateUserUseCaseTest extends TestCase
{
    private UserService|MockInterface $userServiceMock;

    private LoggerInterface|MockInterface $loggerMock;

    private CreateUserUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userServiceMock = $this->createMock(UserService::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);

        $this->useCase = new CreateUserUseCase(
            $this->userServiceMock,
            $this->loggerMock
        );
    }

    public function test_should_create_user_successfully(): void
    {
        // Arrange
        $input = [
            'name' => 'Jhon Due',
            'email' => 'test@gmail.com',
            'phone_number' => '11942421224',
            'password' => 'Test@20',
        ];

        $entitySanitized = [
            'id' => null,
            'name' => $input['name'],
            'email' => $input['email'],
            'phone_number' => $input['phone_number'],
            'password' => $input['password'],
        ];

        $this->userServiceMock
            ->expects($this->once())
            ->method('findEmailInUse')
            ->with($input['email']);

        $this->userServiceMock
            ->expects($this->once())
            ->method('sanitize')
            ->willReturn($entitySanitized);

        $this->userServiceMock
            ->expects($this->once())
            ->method('create')
            ->willReturn(
                UserEntity::fromArray($entitySanitized)
            );

        // Act
        $this->useCase
            ->execute(
                new CreateUserInputDTO([
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'phoneNumber' => $input['phone_number'],
                    'password' => $input['password'],
                ])
            );
    }

    public function test_should_email_already_in_use(): void
    {
        // Arrange
        $this->expectException(EmailAlreadyInUseException::class);
        $this->expectExceptionMessage('O e-mail já esta sendo utilizado');

        $input = [
            'name' => 'Jhon Due',
            'email' => 'test@gmail.com',
            'phone_number' => '11942421224',
            'password' => 'Test@20',
        ];

        $this->userServiceMock
            ->expects($this->once())
            ->method('findEmailInUse')
            ->with($input['email'])
            ->willThrowException(
                new EmailAlreadyInUseException(),
            );

        $this->userServiceMock
            ->expects($this->never())
            ->method('create');

        $this->loggerMock
            ->expects($this->once())
            ->method('error');

        // Act
        $this->useCase
            ->execute(
                new CreateUserInputDTO([
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'phoneNumber' => $input['phone_number'],
                    'password' => $input['password'],
                ])
            );
    }

    public function test_should_not_create_user(): void
    {
        // Arrange
        $this->expectException(UserNotCreatedException::class);
        $this->expectExceptionMessage('Não foi possível finalizar o cadastro');

        $input = [
            'name' => 'Jhon Due',
            'email' => 'test@gmail.com',
            'phone_number' => '11942421224',
            'password' => 'Test@20',
        ];

        $entitySanitized = [
            'id' => null,
            'name' => $input['name'],
            'email' => $input['email'],
            'phone_number' => $input['phone_number'],
            'password' => $input['password'],
        ];

        $this->userServiceMock
            ->expects($this->once())
            ->method('findEmailInUse')
            ->with($input['email']);

        $this->userServiceMock
            ->expects($this->once())
            ->method('sanitize')
            ->willReturn($entitySanitized);

        $this->userServiceMock
            ->expects($this->once())
            ->method('create')
            ->willThrowException(
                new UserNotCreatedException()
            );

        $this->loggerMock
            ->expects($this->once())
            ->method('error');

        // Act
        $this->useCase
            ->execute(
                new CreateUserInputDTO([
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'phoneNumber' => $input['phone_number'],
                    'password' => $input['password'],
                ])
            );
    }
}
