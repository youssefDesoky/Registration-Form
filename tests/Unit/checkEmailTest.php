<?php


namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckEmailTest extends TestCase
{
    use RefreshDatabase; // Reset database after each test
    
    public function test_checkEmail_with_existing_email_returns_error_message()
    {
        // Create a user with a known email address
        $user = new User();
        $user->full_name = 'Email Test User';
        $user->user_name = 'emailuser';
        $user->phone_number = '201234567890';
        $user->whatsapp_number = '201234567891';
        $user->password = 'password123';
        $user->user_email = 'existing@example.com';
        $user->user_address = 'Email Address';
        $user->user_image = 'test_image_path.jpg';
        $user->save();

        // Make request to check email endpoint with existing email
        $response = $this->post('/validate/email', [
            'user_email' => 'existing@example.com'
        ]);

        // Assert we get the expected error message
        $response->assertStatus(200);
        $this->assertEquals('Email already in use', $response->getContent());
    }

    public function test_checkEmail_with_new_email_returns_empty_response()
    {
        // Make request to check email endpoint with an email that doesn't exist
        $response = $this->post('/validate/email', [
            'user_email' => 'new@example.com'
        ]);

        // Assert we get an empty response (indicating email is available)
        $response->assertStatus(200);
        $this->assertEquals('', $response->getContent());
    }
}