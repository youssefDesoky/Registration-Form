<?php


namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class checkUsernameTest extends TestCase
{
    use RefreshDatabase; // Reset database after each test
    
    public function test_checkUsername_with_existing_username_returns_error_message()
    {
        // Create a user with a known username
        $user = new User();
        $user->full_name = 'Test User';
        $user->user_name = 'existinguser';
        $user->phone_number = '201234567890';
        $user->whatsapp_number = '201234567891';
        $user->password = 'password123';
        $user->user_email = 'test@example.com';
        $user->user_address = 'Test Address';
        $user->user_image = 'test_image_path.jpg';
        $user->save();

        // Make request to check username endpoint with existing username
        $response = $this->post('/validate/username', [  
            'user_name' => 'existinguser'
        ]);

        // Assert we get the expected error message
        $response->assertStatus(200);
        $this->assertEquals('Username already taken', $response->getContent());
    }

    public function test_checkUsername_with_new_username_returns_empty_response()
    {
        // Make request to check username endpoint with a username that doesn't exist
        $response = $this->post('/validate/username', [  
            'user_name' => 'newusername'
        ]);

        // Assert we get an empty response (indicating username is available)
        $response->assertStatus(200);
        $this->assertEquals('', $response->getContent());
    }
}