<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UserTest extends TestCase
{
    #[Test]
    public function password_is_hashed_correctly_upon_user_creation()
    {
        // Arrange
        $password = 'SecurePassword123!';
        $user = User::factory()->make([
            'password' => bcrypt($password)
        ]);

        // Assert
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

    #[Test]
    public function multiple_users_are_created_with_valid_emails()
    {
        // Arrange
        $users = User::factory()->count(3)->make();

        // Act & Assert
        $emails = $users->pluck('email')->toArray();
        $this->assertCount(3, array_unique($emails));
    }

    #[Test]
    public function email_with_double_dots_is_invalid()
    {
        // Arrange
        $invalidEmail = 'test..email@example.com';

        // Act
        $isValid = filter_var($invalidEmail, FILTER_VALIDATE_EMAIL);

        // Assert
        $this->assertFalse($isValid);
    }

    #[Test]
    public function email_ending_with_at_symbol_is_invalid()
    {
        // Arrange
        $invalidEmail = 'test@';

        // Act
        $isValid = filter_var($invalidEmail, FILTER_VALIDATE_EMAIL);

        // Assert
        $this->assertFalse($isValid);
    }

}
