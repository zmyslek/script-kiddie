<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function user_password_is_hashed_upon_creation()
    {
        $plainPassword = 'MySecurePassword123!';
        $user = User::create([
            'name' => 'Unit Tester',
            'email' => 'unittest@example.com',
            'password' => $plainPassword,
        ]);

        $this->assertNotEquals($plainPassword, $user->password);
        $this->assertTrue(Hash::check($plainPassword, $user->password));
    }
}
