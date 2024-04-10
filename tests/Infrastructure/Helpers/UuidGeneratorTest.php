<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Helpers;

use App\Infrastructure\Helpers\UuidGenerator;
use Tests\TestCase;

class UuidGeneratorTest extends TestCase
{
    private UuidGenerator $helper;

    protected function setUp(): void
    {
        parent::setUp();

        $this->helper = new UuidGenerator();
    }

    public function test_should_generate_uuid(): void
    {
        // Act
        $output = $this->helper->generateUuid();

        // Assert
        $this->assertIsString($output);
    }
}
