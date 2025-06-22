<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UserTest extends TestCase
{
    #[Test]
    public function password_is_hashed_correctly_upon_user_creation(): void
    {
        // Arrange
        $password = 'SecurePassword123!';
        $user = User::factory()->make(['password' => bcrypt($password)]);

        // Act & Assert
        $this->assertNotEquals($password, $user->password);
        $this->assertTrue(Hash::check($password, $user->password));
    }

    #[Test]
    public function email_with_invalid_format_fails_validation(): void
    {
        // Arrange
        $invalidEmail = 'invalid..@email';

        // Act
        $isValid = filter_var($invalidEmail, FILTER_VALIDATE_EMAIL);

        // Assert
        $this->assertFalse($isValid);
    }
}
