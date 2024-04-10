<?php

declare(strict_types=1);

namespace Tests\Application\UseCases\Cart;

use App\Application\Broker\Producer\PaymentCartProducerInterface;
use App\Application\DTO\Cart\PayCartInputDTO;
use App\Application\DTO\Cart\PayCartOutputDTO;
use App\Application\Helpers\UuidGeneratorInterface;
use App\Application\UseCases\Cart\PayCartUseCase;
use App\Domain\Entities\CartEntity;
use App\Domain\Entities\PaymentEntity;
use App\Domain\Enums\CartStatusEnum;
use App\Domain\Enums\PaymentMethodEnum;
use App\Domain\Enums\PaymentStatusEnum;
use App\Domain\Exceptions\Payment\PaymentNotCreatedException;
use App\Domain\Exceptions\Payment\PaymentUnableToReceiveException;
use App\Domain\Helpers\CryptographyInterface;
use App\Domain\Services\CartService;
use App\Domain\Services\LoggerInterface;
use App\Domain\Services\PaymentService;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class PayCartUseCaseTest extends TestCase
{
    private CartService|MockInterface $cartServiceMock;

    private PaymentService|MockInterface $paymentServiceMock;

    private LoggerInterface|MockInterface $loggerMock;

    private PaymentCartProducerInterface|MockInterface $paymentCartProducerMock;

    private CryptographyInterface|MockInterface $cryptographyMock;

    private UuidGeneratorInterface|MockInterface $uuidGeneratorMock;

    private PayCartUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cartServiceMock = $this->createMock(CartService::class);
        $this->paymentServiceMock = $this->createMock(PaymentService::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);
        $this->paymentCartProducerMock = $this->createMock(PaymentCartProducerInterface::class);
        $this->cryptographyMock = $this->createMock(CryptographyInterface::class);
        $this->uuidGeneratorMock = $this->createMock(UuidGeneratorInterface::class);

        $this->useCase = new PayCartUseCase(
            $this->cartServiceMock,
            $this->paymentServiceMock,
            $this->loggerMock,
            $this->paymentCartProducerMock,
            $this->cryptographyMock,
            $this->uuidGeneratorMock,
        );
    }

    public function test_should_pay_cart_successfully(): void
    {
        // Arrange
        $input = [
            'user_id' => 1,
            'cart_uuid' => '145998e1-b25c-4b33-ad80-d1cfd7de570d',
            'method' => PaymentMethodEnum::CREDIT_CARD->value,
            'card' => [],
        ];

        $uuid = '2af89c92-c0e3-4798-9170-ff88673ac571';

        $entitySanitized = [
            'id' => 1,
            'uuid' => $uuid,
            'user_id' => $input['user_id'],
            'cart_uuid' => $input['cart_uuid'],
            'method' => $input['method'],
            'status' => PaymentStatusEnum::PENDING->value,
        ];

        $cartEntity = CartEntity::fromArray([
            'id' => 1,
            'uuid' => $input['cart_uuid'],
            'user_id' => $input['user_id'],
            'items' => [],
            'status' => CartStatusEnum::PENDING->value,
            'created_at' => now(),
        ]);

        $this->uuidGeneratorMock
            ->expects($this->once())
            ->method('generateUuid')
            ->willReturn($uuid);

        $this->cartServiceMock
            ->expects($this->once())
            ->method('getCartFromUser')
            ->willReturn($cartEntity);

        $this->paymentServiceMock
            ->expects($this->once())
            ->method('sanitize')
            ->willReturn($entitySanitized);

        $this->paymentCartProducerMock
            ->expects($this->once())
            ->method('produce')
            ->willReturnSelf();

        $this->paymentServiceMock
            ->expects($this->once())
            ->method('create')
            ->willReturn(
                PaymentEntity::fromArray(
                    $entitySanitized + [
                        'created_at' => now(),
                    ],
                ),
            );

        // Act
        $useCase = $this->useCase
            ->execute(
                new PayCartInputDTO([
                    'userId' => $input['user_id'],
                    'cartUuid' => $input['cart_uuid'],
                    'method' => $input['method'],
                    'card' => $input['card'],
                ])
            );

        // Assert
        $this->assertEquals(
            new PayCartOutputDTO([
                'uuid' => $entitySanitized['uuid'],
                'method' => $entitySanitized['method'],
                'status' => $entitySanitized['status'],
            ]),
            $useCase
        );
    }

    public function test_should_not_create_payment_to_cart(): void
    {
        // Arrange
        $this->expectException(PaymentNotCreatedException::class);
        $this->expectExceptionMessage('Não foi possível criar o pagamento');

        $input = [
            'user_id' => 1,
            'cart_uuid' => '145998e1-b25c-4b33-ad80-d1cfd7de570d',
            'method' => PaymentMethodEnum::CREDIT_CARD->value,
            'card' => [],
        ];

        $uuid = '2af89c92-c0e3-4798-9170-ff88673ac571';

        $entitySanitized = [
            'id' => 1,
            'uuid' => $uuid,
            'user_id' => $input['user_id'],
            'cart_uuid' => $input['cart_uuid'],
            'method' => $input['method'],
            'status' => PaymentStatusEnum::PENDING->value,
        ];

        $cartEntity = CartEntity::fromArray([
            'id' => 1,
            'uuid' => $input['cart_uuid'],
            'user_id' => $input['user_id'],
            'items' => [],
            'status' => CartStatusEnum::PENDING->value,
            'created_at' => now(),
        ]);

        $this->uuidGeneratorMock
            ->expects($this->once())
            ->method('generateUuid')
            ->willReturn($uuid);

        $this->cartServiceMock
            ->expects($this->once())
            ->method('getCartFromUser')
            ->willReturn($cartEntity);

        $this->paymentServiceMock
            ->expects($this->once())
            ->method('sanitize')
            ->willReturn($entitySanitized);

        $this->paymentCartProducerMock
            ->expects($this->never())
            ->method('produce');

        $this->paymentServiceMock
            ->expects($this->once())
            ->method('create')
            ->willThrowException(
                new PaymentNotCreatedException()
            );

        $this->loggerMock
            ->expects($this->once())
            ->method('error');

        // Act
        $this->useCase
            ->execute(
                new PayCartInputDTO([
                    'userId' => $input['user_id'],
                    'cartUuid' => $input['cart_uuid'],
                    'method' => $input['method'],
                    'card' => $input['card'],
                ])
            );
    }

    public function test_should_not_receive_payment_when_already_exists(): void
    {
        // Arrange
        $this->expectException(PaymentUnableToReceiveException::class);
        $this->expectExceptionMessage('Já existe um pagamento em andamento');

        $input = [
            'user_id' => 1,
            'cart_uuid' => '145998e1-b25c-4b33-ad80-d1cfd7de570d',
            'method' => PaymentMethodEnum::CREDIT_CARD->value,
            'card' => [],
        ];

        $cartEntity = CartEntity::fromArray([
            'id' => 1,
            'uuid' => $input['cart_uuid'],
            'user_id' => $input['user_id'],
            'items' => [],
            'status' => CartStatusEnum::PENDING->value,
            'created_at' => now(),
        ]);

        $this->uuidGeneratorMock
            ->expects($this->never())
            ->method('generateUuid');

        $this->cartServiceMock
            ->expects($this->once())
            ->method('getCartFromUser')
            ->willReturn($cartEntity);

        $this->paymentServiceMock
            ->expects($this->once())
            ->method('shouldCanReceivePayment')
            ->willThrowException(
                new PaymentUnableToReceiveException()
            );

        $this->paymentServiceMock
            ->expects($this->never())
            ->method('sanitize');

        $this->paymentCartProducerMock
            ->expects($this->never())
            ->method('produce');

        $this->paymentServiceMock
            ->expects($this->never())
            ->method('create');

        $this->loggerMock
            ->expects($this->once())
            ->method('error');

        // Act
        $this->useCase
            ->execute(
                new PayCartInputDTO([
                    'userId' => $input['user_id'],
                    'cartUuid' => $input['cart_uuid'],
                    'method' => $input['method'],
                    'card' => $input['card'],
                ])
            );
    }
}
