<?php

declare(strict_types=1);

namespace Tests\Domain\Payment\Entity;

use App\Domain\Payment\Entity\PaymentEntity;
use App\Domain\Payment\Enum\PaymentMethodEnum;
use App\Domain\Payment\Enum\PaymentStatusEnum;
use PHPUnit\Framework\TestCase;

class PaymentEntityTest extends TestCase
{
    private array $data;

    public function setUp(): void
    {
        parent::setUp();

        $this->data = [
            'id' => 1,
            'uuid' => '81a695db-55a8-4b85-845f-b49f6fd8ad40',
            'user_id' => 1,
            'cart_uuid' => 'bcf89a3f-09ed-4165-a9dd-491ed4f3c064',
            'method' => PaymentMethodEnum::CREDIT_CARD->value,
            'status' => PaymentStatusEnum::PAID->value,
            'approved_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function test_should_create_payment_entity_from_array(): void
    {
        // Act
        $user = PaymentEntity::fromArray($this->data);

        // Assert
        $this->assertInstanceOf(PaymentEntity::class, $user);
        $this->assertEquals($this->data['id'], $user->getId());
        $this->assertEquals($this->data['uuid'], $user->getUuid());
        $this->assertEquals($this->data['user_id'], $user->getUserId());
        $this->assertEquals($this->data['cart_uuid'], $user->getCartUuid());
        $this->assertEquals($this->data['method'], $user->getMethod());
        $this->assertEquals($this->data['status'], $user->getStatus());
        $this->assertEquals($this->data['approved_at']->format('Y-m-d H:i'), $user->getApprovedAt()->format('Y-m-d H:i'));
        $this->assertEquals($this->data['created_at']->format('Y-m-d H:i'), $user->getCreatedAt()->format('Y-m-d H:i'));
        $this->assertEquals($this->data['updated_at']->format('Y-m-d H:i'), $user->getUpdatedAt()->format('Y-m-d H:i'));
    }

    public function test_should_transform_payment_entity_in_array(): void
    {
        // Act
        $user = PaymentEntity::fromArray($this->data)->toArray();

        // Assert
        $this->assertEquals($this->data['id'], $user['id']);
        $this->assertEquals($this->data['uuid'], $user['uuid']);
        $this->assertEquals($this->data['user_id'], $user['user_id']);
        $this->assertEquals($this->data['cart_uuid'], $user['cart_uuid']);
        $this->assertEquals($this->data['method'], $user['method']);
        $this->assertEquals($this->data['status'], $user['status']);
        $this->assertEquals($this->data['approved_at']->format('Y-m-d H:i'), $user['approved_at']->format('Y-m-d H:i'));
        $this->assertEquals($this->data['created_at']->format('Y-m-d H:i'), $user['created_at']->format('Y-m-d H:i'));
        $this->assertEquals($this->data['updated_at']->format('Y-m-d H:i'), $user['updated_at']->format('Y-m-d H:i'));
    }
}
