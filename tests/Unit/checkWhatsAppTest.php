<?php


namespace Tests\Unit;

use App\Models\User;
use App\Http\Controllers\ValidationController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

class CheckWhatsAppTest extends TestCase
{
    use RefreshDatabase; // Reset database after each test
    
    public function test_checkWhatsApp_with_existing_number_returns_error_message()
    {
        // Create a user with a known WhatsApp number
        $user = new User();
        $user->full_name = 'WhatsApp Test User';
        $user->user_name = 'whatsappuser';
        $user->phone_number = '201234567890';
        $user->whatsapp_number = '201234567891';
        $user->password = 'password123';
        $user->user_email = 'whatsapp@example.com';
        $user->user_address = 'WhatsApp Address';
        $user->user_image = 'test_image_path.jpg';
        $user->save();

        // Make request to check WhatsApp endpoint with existing number
        $response = $this->post('/validate/whatsapp', [
            'whatsapp_number' => '201234567891'
        ]);

        // Assert we get the expected error message
        $response->assertStatus(200);
        $this->assertEquals('WhatsApp number already in use', $response->getContent());
    }

    public function test_checkWhatsApp_with_new_number_returns_empty_response()
    {
        // Make request to check WhatsApp endpoint with a number that doesn't exist
        $response = $this->post('/validate/whatsapp', [
            'whatsapp_number' => '201987654321'
        ]);

        // Assert we get an empty response (indicating WhatsApp number is available)
        $response->assertStatus(200);
        $this->assertEquals('', $response->getContent());
    }

    public function test_checkWhatsApp_handles_exceptions_gracefully()
    {
        // Mock the Log facade to verify it's called
        Log::shouldReceive('error')
            ->once()
            ->with(Mockery::pattern('/WhatsApp validation error:.*/'));
        
        // Create a mock Request
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('input')
            ->with('whatsapp_number')
            ->andThrow(new \Exception('Database connection failed'));
        
        // Create controller and call the method directly
        $controller = new ValidationController();
        $response = $controller->checkWhatsApp($request);
        
        // Assert we get the expected error response
        $this->assertEquals(500, $response->status());
        $this->assertEquals('Error checking WhatsApp number', $response->getContent());
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}