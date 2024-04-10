<?php

declare(strict_types=1);

namespace Tests\Domain\Entities;

use App\Domain\Entities\UserEntity;
use PHPUnit\Framework\TestCase;

class UserEntityTest extends TestCase
{
    private array $data;

    public function setUp(): void
    {
        parent::setUp();

        $this->data = [
            'id' => 1,
            'name' => 'Jhon Due',
            'email' => 'jhondue@email.com',
            'phone_number' => '551199999999',
            'password' => 'JhonDue',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function test_should_create_user_entity_from_array(): void
    {
        // Act
        $user = UserEntity::fromArray($this->data);

        // Assert
        $this->assertInstanceOf(UserEntity::class, $user);
        $this->assertEquals($this->data['id'], $user->getId());
        $this->assertEquals($this->data['name'], $user->getName());
        $this->assertEquals($this->data['email'], $user->getEmail());
        $this->assertEquals($this->data['phone_number'], $user->getPhoneNumber());
        $this->assertEquals($this->data['password'], $user->getPassword());
        $this->assertEquals($this->data['created_at']->format('Y-m-d H:i'), $user->getCreatedAt()->format('Y-m-d H:i'));
        $this->assertEquals($this->data['updated_at']->format('Y-m-d H:i'), $user->getUpdatedAt()->format('Y-m-d H:i'));
    }

    public function test_should_transform_user_entity_in_array(): void
    {
        // Act
        $user = UserEntity::fromArray($this->data)->toArray();

        // Assert
        $this->assertEquals($this->data['id'], $user['id']);
        $this->assertEquals($this->data['name'], $user['name']);
        $this->assertEquals($this->data['email'], $user['email']);
        $this->assertEquals($this->data['phone_number'], $user['phone_number']);
        $this->assertEquals($this->data['password'], $user['password']);
        $this->assertEquals($this->data['created_at']->format('Y-m-d H:i'), $user['created_at']->format('Y-m-d H:i'));
        $this->assertEquals($this->data['updated_at']->format('Y-m-d H:i'), $user['updated_at']->format('Y-m-d H:i'));
    }
}
