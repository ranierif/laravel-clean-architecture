<?php

declare(strict_types=1);

namespace Tests\Application\UseCases\Cart;

use App\Application\DTO\Cart\CreateCartInputDTO;
use App\Application\DTO\Cart\CreateCartOutputDTO;
use App\Application\Helpers\UuidGeneratorInterface;
use App\Application\UseCases\Cart\CreateCartUseCase;
use App\Domain\Entities\CartEntity;
use App\Domain\Enums\CartStatusEnum;
use App\Domain\Exceptions\Cart\CartNotCreatedException;
use App\Domain\Services\CartService;
use App\Domain\Services\LoggerInterface;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class CreateCartUseCaseTest extends TestCase
{
    private CartService|MockInterface $cartServiceMock;

    private LoggerInterface|MockInterface $loggerMock;

    private UuidGeneratorInterface|MockInterface $uuidGeneratorMock;

    private CreateCartUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cartServiceMock = $this->createMock(CartService::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);
        $this->uuidGeneratorMock = $this->createMock(UuidGeneratorInterface::class);

        $this->useCase = new CreateCartUseCase(
            $this->cartServiceMock,
            $this->loggerMock,
            $this->uuidGeneratorMock
        );
    }

    public function test_should_create_cart_successfully(): void
    {
        // Arrange
        $input = [
            'user_id' => 1,
            'items' => [],
        ];

        $uuid = '4f00e02f-b7ba-4a11-b754-bb5a1a5b8ee3';

        $entitySanitized = [
            'id' => null,
            'uuid' => $uuid,
            'user_id' => $input['user_id'],
            'items' => $input['items'],
            'status' => CartStatusEnum::PENDING->value,
        ];

        $this->uuidGeneratorMock
            ->expects($this->once())
            ->method('generateUuid')
            ->willReturn($uuid);

        $this->cartServiceMock
            ->expects($this->once())
            ->method('sanitize')
            ->willReturn($entitySanitized);

        $this->cartServiceMock
            ->expects($this->once())
            ->method('create')
            ->willReturn(
                CartEntity::fromArray(
                    $entitySanitized + [
                        'created_at' => now(),
                    ],
                ),
            );

        // Act
        $useCase = $this->useCase
            ->execute(
                new CreateCartInputDTO([
                    'userId' => $input['user_id'],
                    'items' => $input['items'],
                ])
            );

        // Assert
        $this->assertEquals(
            new CreateCartOutputDTO([
                'uuid' => $entitySanitized['uuid'],
                'items' => $entitySanitized['items'],
                'status' => $entitySanitized['status'],
                'created_at' => now()->format('Y-m-d H:i'),
                'approved_at' => null,
            ]),
            $useCase
        );
    }

    public function test_should_not_create_cart(): void
    {
        // Arrange
        $this->expectException(CartNotCreatedException::class);
        $this->expectExceptionMessage('Não foi possível criar o carrinho');

        $input = [
            'user_id' => 1,
            'items' => [],
        ];

        $uuid = '4f00e02f-b7ba-4a11-b754-bb5a1a5b8ee3';

        $entitySanitized = [
            'id' => null,
            'uuid' => $uuid,
            'user_id' => $input['user_id'],
            'items' => $input['items'],
            'status' => CartStatusEnum::PENDING->value,
        ];

        $this->uuidGeneratorMock
            ->expects($this->once())
            ->method('generateUuid')
            ->willReturn($uuid);

        $this->cartServiceMock
            ->expects($this->once())
            ->method('sanitize')
            ->willReturn($entitySanitized);

        $this->cartServiceMock
            ->expects($this->once())
            ->method('create')
            ->willThrowException(
                new CartNotCreatedException()
            );

        $this->loggerMock
            ->expects($this->once())
            ->method('error');

        // Act
        $this->useCase
            ->execute(
                new CreateCartInputDTO([
                    'userId' => $input['user_id'],
                    'items' => $input['items'],
                ])
            );
    }
}
