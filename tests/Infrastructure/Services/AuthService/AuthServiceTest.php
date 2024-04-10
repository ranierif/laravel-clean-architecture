<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Services\AuthService;

use App\Infrastructure\Services\AuthService\JwtAuthService;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    private JwtAuthService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new JwtAuthService();
    }

    public function test_should_generate_token(): void
    {
        // Arrange
        $input = [
            'email' => 'test@gmail.com',
            'password' => 'Test@12',
        ];

        $mockToken = 'test-token';

        Auth::shouldReceive('attempt')
            ->with($input)
            ->andReturn($mockToken);

        // Act
        $output = $this->service
            ->generateToken(
                $input['email'],
                $input['password']
            );

        // Assert
        $expectedOutput = $mockToken;

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_should_validate_credentials(): void
    {
        // Arrange
        $input = [
            'email' => 'test@gmail.com',
            'password' => 'Test@12',
        ];

        Auth::shouldReceive('validate')
            ->with($input)
            ->andReturn(true);

        // Act
        $output = $this->service
            ->validateCredentials($input);

        // Assert
        $this->assertTrue($output);
    }

    public function test_should_validate_token(): void
    {
        // Arrange
        Auth::shouldReceive('authenticate')
            ->andReturn(true);

        // Act
        $output = $this->service->validateToken();

        // Assert
        $this->assertTrue($output);
    }

    public function test_should_logout(): void
    {
        // Arrange
        $this->expectNotToPerformAssertions();

        Auth::shouldReceive('logout')
            ->andReturn(true);

        // Act & Assert
        $this->service->logout();
    }
}
