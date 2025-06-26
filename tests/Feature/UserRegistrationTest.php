<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use WithoutMiddleware;
    use RefreshDatabase;
    #[Test]
    public function user_can_register_with_valid_data()
    {
        // Arrange
        $newUserData = User::factory()->make()->toArray();
        $newUserData['password'] = 'password123';
        $newUserData['password_confirmation'] = 'password123';

        // Act
        $response = $this->post('/register', $newUserData);

        // Assert
        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', ['email' => $newUserData['email']]);
    }

    #[Test]
    public function user_registration_fails_with_missing_data()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => '',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    #[Test]
    public function registration_fails_with_duplicate_email()
    {
        // Arrange
        User::factory()->create(['email' => 'dupe@example.com']);
        $userData = [
            'name' => 'Another User',
            'email' => 'dupe@example.com',
            'password' => 'anotherpassword',
            'password_confirmation' => 'anotherpassword',
        ];

        // Act
        $response = $this->post('/register', $userData);

        // Assert
        $response->assertSessionHasErrors('email');
    }

    #[Test]
    public function registration_with_invalid_email_fails()
    {
        // Arrange
        $userData = [
            'name' => 'Test User',
            'email' => 'invalid..email@',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        // Act
        $response = $this->post('/register', $userData);

        // Assert
        $response->assertSessionHasErrors(['email']);
    }

    #[Test]
    public function registration_fails_with_double_dot_email()
    {
        // Arrange
        $userData = [
            'name' => 'Edge Case User',
            'email' => 'user..name@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        // Act
        $response = $this->post('/register', $userData);

        // Assert
        $response->assertSessionHasErrors(['email']);
    }

}
