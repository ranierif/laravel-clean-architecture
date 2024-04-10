<?php

declare(strict_types=1);

namespace Tests\Domain\Cart\Entity;

use App\Domain\Cart\Entity\CartEntity;
use App\Domain\Cart\Enum\CartStatusEnum;
use PHPUnit\Framework\TestCase;

class CartEntityTest extends TestCase
{
    private array $data;

    public function setUp(): void
    {
        parent::setUp();

        $this->data = [
            'id' => 1,
            'uuid' => 'a00ddc45-246d-4d67-b204-2e0b99cb399a',
            'user_id' => 1,
            'items' => [],
            'status' => CartStatusEnum::APPROVED->value,
            'approved_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function test_should_create_cart_entity_from_array(): void
    {
        // Act
        $user = CartEntity::fromArray($this->data);

        // Assert
        $this->assertInstanceOf(CartEntity::class, $user);
        $this->assertEquals($this->data['id'], $user->getId());
        $this->assertEquals($this->data['uuid'], $user->getUuid());
        $this->assertEquals($this->data['user_id'], $user->getUserId());
        $this->assertEquals($this->data['items'], $user->getItems());
        $this->assertEquals($this->data['status'], $user->getStatus());
        $this->assertEquals($this->data['approved_at']->format('Y-m-d H:i'), $user->getApprovedAt()->format('Y-m-d H:i'));
        $this->assertEquals($this->data['created_at']->format('Y-m-d H:i'), $user->getCreatedAt()->format('Y-m-d H:i'));
        $this->assertEquals($this->data['updated_at']->format('Y-m-d H:i'), $user->getUpdatedAt()->format('Y-m-d H:i'));
    }

    public function test_should_transform_user_entity_in_array(): void
    {
        // Act
        $user = CartEntity::fromArray($this->data)->toArray();

        // Assert
        $this->assertEquals($this->data['id'], $user['id']);
        $this->assertEquals($this->data['uuid'], $user['uuid']);
        $this->assertEquals($this->data['user_id'], $user['user_id']);
        $this->assertEquals($this->data['items'], $user['items']);
        $this->assertEquals($this->data['status'], $user['status']);
        $this->assertEquals($this->data['approved_at']->format('Y-m-d H:i'), $user['approved_at']->format('Y-m-d H:i'));
        $this->assertEquals($this->data['created_at']->format('Y-m-d H:i'), $user['created_at']->format('Y-m-d H:i'));
        $this->assertEquals($this->data['updated_at']->format('Y-m-d H:i'), $user['updated_at']->format('Y-m-d H:i'));
    }
}
