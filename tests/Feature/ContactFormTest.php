<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use WithoutMiddleware;
    use RefreshDatabase;
    #[Test]
    public function contact_form_submits_successfully()
    {
        // Arrange
        $formData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'Hello world',
        ];

        // Act
        $response = $this->post('/contact', $formData);

        // Assert
        $response->assertStatus(302);
        $response->assertSessionHas('success');
    }

    #[Test]
    public function contact_form_shows_errors_on_invalid_input()
    {
        $response = $this->post('/contact', [
            'name' => '',
            'email' => 'not-an-email',
            'message' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'message']);
    }
}
