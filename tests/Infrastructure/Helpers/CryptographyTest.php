<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Helpers;

use App\Infrastructure\Helpers\Cryptography;
use Tests\TestCase;

class CryptographyTest extends TestCase
{
    private Cryptography $helper;

    protected function setUp(): void
    {
        parent::setUp();

        $this->helper = new Cryptography();
    }

    public function test_should_compare_valid_hash_and_value(): void
    {
        // Arrange
        $input = [
            'hash' => '$2y$04$1U4Gl7.X9L/18srnZwDp8uO5G6GGfE9rl43FAnDtd0SKz8BUbQJ4i',
            'value' => 'CleanArchitecture@2023',
        ];

        // Act
        $output = $this->helper->compare($input['hash'], $input['value']);

        // Assert
        $this->assertTrue($output);
    }

    public function test_should_compare_invalid_hash_and_value(): void
    {
        // Arrange
        $input = [
            'hash' => '$2y$04$1U4Gl7.X9L/18srnZwDp8uO5G6GGfE9rl43FAnDtd0SKz8BUbQJ4i',
            'value' => 'ArchitectureClean@2023',
        ];

        // Act
        $output = $this->helper->compare($input['hash'], $input['value']);

        // Assert
        $this->assertFalse($output);
    }
}
