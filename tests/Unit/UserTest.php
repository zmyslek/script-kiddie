<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function password_is_hashed_correctly_upon_user_creation()
    {
        // Arrange
        $password = 'SecurePassword123!';
        $user = User::factory()->create([
            'password' => $password,
        ]);

        // Act & Assert
        $this->assertNotEquals($password, $user->password);
        $this->assertTrue(Hash::check($password, $user->password));
    }

    /** @test */
    public function email_with_invalid_format_fails_validation()
    {
        // Arrange
        $invalidEmail = 'example..@email';

        // Act
        $isValid = filter_var($invalidEmail, FILTER_VALIDATE_EMAIL);

        // Assert
        $this->assertFalse($isValid);
    }
}
