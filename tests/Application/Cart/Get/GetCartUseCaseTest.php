<?php

declare(strict_types=1);

namespace Tests\Application\Cart\Get;

use App\Application\Cart\Get\GetCartInputDTO;
use App\Application\Cart\Get\GetCartOutputDTO;
use App\Application\Cart\Get\GetCartUseCase;
use App\Domain\Cart\Entity\CartEntity;
use App\Domain\Cart\Enum\CartStatusEnum;
use App\Domain\Cart\Exception\CartNotFoundException;
use App\Domain\Cart\Service\CartService;
use App\Domain\Shared\Service\LoggerInterface;
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
