<?php

declare(strict_types=1);

namespace Tests\Application\UseCases\Cart;

use App\Application\DTO\Cart\GetCartInputDTO;
use App\Application\DTO\Cart\GetCartOutputDTO;
use App\Application\UseCases\Cart\GetCartUseCase;
use App\Domain\Entities\CartEntity;
use App\Domain\Enums\CartStatusEnum;
use App\Domain\Exceptions\Cart\CartNotFoundException;
use App\Domain\Services\CartService;
use App\Domain\Services\LoggerInterface;
use Illuminate\Support\Str;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class GetCartUseCaseTest extends TestCase
{
    private CartService|MockInterface $cartServiceMock;

    private LoggerInterface|MockInterface $loggerMock;

    private GetCartUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cartServiceMock = $this->createMock(CartService::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);

        $this->useCase = new GetCartUseCase(
            $this->cartServiceMock,
            $this->loggerMock
        );
    }

    public function test_should_get_cart_successfully(): void
    {
        // Arrange
        $cartEntity = CartEntity::fromArray([
            'id' => 1,
            'uuid' => Str::uuid()->toString(),
            'user_id' => 1,
            'items' => [],
            'status' => CartStatusEnum::PENDING->value,
            'created_at' => now(),
        ]);

        $this->cartServiceMock
            ->expects($this->once())
            ->method('getCartFromUser')
            ->willReturn($cartEntity);

        // Act
        $useCase = $this->useCase
            ->execute(
                new GetCartInputDTO([
                    'uuid' => $cartEntity->getUuid(),
                    'userId' => $cartEntity->getUserId(),
                ])
            );

        // Assert
        $this->assertEquals(
            new GetCartOutputDTO([
                'uuid' => $cartEntity->getUuid(),
                'items' => $cartEntity->getItems(),
                'status' => $cartEntity->getStatus(),
                'created_at' => $cartEntity->getCreatedAt()->format('Y-m-d H:i'),
                'approved_at' => null,
            ]),
            $useCase
        );
    }

    public function test_should_not_get_cart_when_not_found(): void
    {
        // Arrange
        $this->expectException(CartNotFoundException::class);
        $this->expectExceptionMessage('Não foi possível encontrar o carrinho');

        $this->cartServiceMock
            ->expects($this->once())
            ->method('getCartFromUser')
            ->willThrowException(
                new CartNotFoundException()
            );

        $this->loggerMock
            ->expects($this->once())
            ->method('error');

        // Act
        $this->useCase
            ->execute(
                new GetCartInputDTO([
                    'uuid' => Str::uuid()->toString(),
                    'userId' => 1,
                ])
            );
    }
}