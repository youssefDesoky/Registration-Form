<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckPhoneTest extends TestCase
{
    use RefreshDatabase; // Reset database after each test
    
    public function test_checkPhone_with_existing_number_returns_error_message()
    {
        // Create a user with a known phone number
        $user = new User();
        $user->full_name = 'Phone Test User';
        $user->user_name = 'phoneuser';
        $user->phone_number = '201234567890';
        $user->whatsapp_number = '201234567891';
        $user->password = 'password123';
        $user->user_email = 'phone@example.com';
        $user->user_address = 'Phone Address';
        $user->user_image = 'test_image_path.jpg';
        $user->save();

        // Make request to check phone endpoint with existing phone
        $response = $this->post('/validate/phone', [
            'phone_number' => '201234567890'
        ]);

        // Assert we get the expected error message
        $response->assertStatus(200);
        $this->assertEquals('Phone number already in use', $response->getContent());
    }

    public function test_checkPhone_with_new_number_returns_empty_response()
    {
        // Make request to check phone endpoint with a phone that doesn't exist
        $response = $this->post('/validate/phone', [
            'phone_number' => '201987654321'
        ]);

        // Assert we get an empty response (indicating phone is available)
        $response->assertStatus(200);
        $this->assertEquals('', $response->getContent());
    }
}