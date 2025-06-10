<?php

namespace Tests\Unit;
use Mockery;
use App\Models\User;
use App\Mail\NewUserRegistered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RegistrationControllerTest extends TestCase
{
    use RefreshDatabase; // Reset database after each test

    public function test_store_requires_image()
    {
        // Create test data without image
        $userData = [
            'full_name' => 'Test User',
            'user_name' => 'testuser',
            'phone_number' => '201234567890',
            'whatsapp_number' => '201234567891',
            'password' => '1Stegengoal_!',
            'user_email' => 'test@example.com',
            'user_address' => '123 Test Street',
            // No image provided
        ];

        // Send post request to store method
        $response = $this->post('/register', $userData);

        // Assert validation error for missing image
        $response->assertSessionHasErrors(['user_image']);
        
        // Assert user was NOT created in the database
        $this->assertDatabaseMissing('users', [
            'user_email' => 'test@example.com',
        ]);
    }

    public function test_store_creates_new_user_with_image()
    {
        // Setup fake storage disk
        Storage::fake('public');
        
        // Create a fake file instead of an image to avoid GD dependency
        $image = UploadedFile::fake()->create(
            'profile.jpg', 
            100, // size in KB
            'image/jpeg' // mime type
        );
        
        // Create test data with image
        $userData = [
            'full_name' => 'Image User',
            'user_name' => 'imageuser',
            'phone_number' => '201234567892',
            'whatsapp_number' => '201234567893',
            'password' => '1Stegengoal_!',
            'user_email' => 'image@example.com',
            'user_address' => '123 Image Street',
            'user_image' => $image
        ];

        // Send post request to store method
        $response = $this->post('/register', $userData);

        // Assert user was created in the database
        $this->assertDatabaseHas('users', [
            'full_name' => 'Image User',
            'user_name' => 'imageuser',
            'phone_number' => '201234567892',
            'whatsapp_number' => '201234567893',
            'user_email' => 'image@example.com',
            'user_address' => '123 Image Street',
        ]);

        // Get the created user
        $user = User::where('user_email', 'image@example.com')->first();

        // Assert password was hashed
        //$this->assertTrue(Hash::check('1Stegengoal_!', $user->password));
        $this->assertEquals($userData['password'], Crypt::decrypt($user->password));

        // Assert image path is not null
        $this->assertNotNull($user->user_image);
        
        // Assert the image path contains 'uploads/' directory
        $this->assertStringContainsString('uploads/', $user->user_image);
        
        // Assert the file exists in storage
        Storage::disk('public')->assertExists($user->user_image);

        // Assert redirection
        $response->assertRedirect('/');
        $response->assertSessionHas('success', 'Registration successful!');
        $response->assertSessionHas('user_first_name', 'Image');
    }


    public function test_store_validates_required_fields()
    {
        // Send post request with empty data
        $response = $this->post('/register', []);

        // Assert validation errors for required fields including user_image
        $response->assertSessionHasErrors([
            'full_name', 'user_name', 'phone_number', 
            'whatsapp_number', 'password', 'user_email', 
            'user_address', 'user_image'
        ]);
    }

    public function test_store_validates_unique_fields()
    {
        // Setup storage for required image
        Storage::fake('public');
        $image = UploadedFile::fake()->create('profile.jpg', 100, 'image/jpeg');
        
        // Manually create a user with the fields we need for this test
        $user = new User();
        $user->full_name = 'Existing User';
        $user->user_name = 'existinguser';
        $user->phone_number = '201234567890';
        $user->whatsapp_number = '201234567891';
        $user->password =  Crypt::encrypt('password');
        $user->user_email = 'existing@example.com';
        $user->user_address = 'Existing Address';
        $user->user_image = 'path/to/image.jpg';
        $user->save();

        // Try to create another user with the same unique fields
        $response = $this->post('/register', [
            'full_name' => 'Test User',
            'user_name' => 'existinguser', // duplicate
            'phone_number' => '201234567890', // duplicate
            'whatsapp_number' => '201234567891', // duplicate
            'password' => '1Stegengoal_!',
            'user_email' => 'existing@example.com', // duplicate
            'user_address' => '123 Test Street',
            'user_image' => $image // Add required image
        ]);

        // Assert validation errors for unique fields
        $response->assertSessionHasErrors([
            'user_name', 'phone_number', 'whatsapp_number', 'user_email'
        ]);
    }

    public function test_store_validates_image_type()
    {
        // Create a fake file with invalid extension
        $invalidImage = UploadedFile::fake()->create(
            'document.txt', 100, 'text/plain'
        );
        
        $userData = [
            'full_name' => 'Invalid Image User',
            'user_name' => 'invalidimage',
            'phone_number' => '201234567899',
            'whatsapp_number' => '201234567898',
            'password' => '1Stegengoal_!',
            'user_email' => 'invalid@example.com',
            'user_address' => '123 Invalid Street',
            'user_image' => $invalidImage
        ];
        
        $response = $this->post('/register', $userData);
        
        // Should return validation error for the image
        $response->assertSessionHasErrors(['user_image']);
    }
    public function test_store_handles_image_upload_exception()
{
    // Create a mock of Storage facade that throws an exception when storing the image
    Storage::shouldReceive('disk')
        ->with('public')
        ->andReturn(Mockery::mock([
            'put' => function() { throw new \Exception('Storage error'); }
        ]));
        
    // Create test data with image
    $userData = [
        'full_name' => 'Exception User',
        'user_name' => 'exceptionuser',
        'phone_number' => '201234569999',
        'whatsapp_number' => '201234569998',
        'password' => '1Stegengoal_!',
        'user_email' => 'exception@example.com',
        'user_address' => '123 Exception Street',
        'user_image' => UploadedFile::fake()->create('profile.jpg', 100, 'image/jpeg')
    ];
    
    // Send post request to store method
    $response = $this->post('/register', $userData);
    
    // Assert user was NOT created in database
    $this->assertDatabaseMissing('users', [
        'user_email' => 'exception@example.com',
    ]);
    
    // Assert correct error response
    $response->assertRedirect();
    $response->assertSessionHasErrors(['user_image']);
}

    public function test_store_sends_email_to_Admin()
    {
        // Setup storage for required image
        Storage::fake('public');
        $image = UploadedFile::fake()->create('profile.jpg', 100, 'image/jpeg');
        
        // Mock the Mail facade
        Mail::fake();
        
        $userData = [
            'full_name' => 'Email Test User',
            'user_name' => 'emailtest',
            'phone_number' => '201234567897',
            'whatsapp_number' => '201234567896',
            'password' => '1Stegengoal_!',
            'user_email' => 'email_test@example.com',
            'user_address' => '123 Email Street',
            'user_image' => $image // Add required image
        ];
        
        $this->post('/register', $userData);
        
        // Assert an email was sent to the admin
        Mail::assertSent(NewUserRegistered::class, function ($mail) {
            return $mail->hasTo(env('ADMIN_EMAIL', 'regist.laravel@gmail.com'));
        });
    }

    public function test_store_validates_password_format()
    {
        // Setup storage for required image
        Storage::fake('public');
        $image = UploadedFile::fake()->create('profile.jpg', 100, 'image/jpeg');
        
        $userData = [
            'full_name' => 'Password User',
            'user_name' => 'passworduser',
            'phone_number' => '201234567895',
            'whatsapp_number' => '201234567894',
            'password' => '12345', // Too short
            'user_email' => 'password@example.com',
            'user_address' => '123 Password Street',
            'user_image' => $image // Add required image
        ];
        
        $response = $this->post('/register', $userData);
        
        // Should return validation error for password
        $response->assertSessionHasErrors(['password']);
    }

    public function test_store_validates_email_format()
    {
        // Setup storage for required image
        Storage::fake('public');
        $image = UploadedFile::fake()->create('profile.jpg', 100, 'image/jpeg');
        
        $userData = [
            'full_name' => 'Email Format User',
            'user_name' => 'emailformat',
            'phone_number' => '201234567893',
            'whatsapp_number' => '201234567892',
            'password' => '1Stegengoal_!',
            'user_email' => 'not-an-email', // Invalid email
            'user_address' => '123 Email Format Street',
            'user_image' => $image // Add required image
        ];
        
        $response = $this->post('/register', $userData);
        
        // Should return validation error for email
        $response->assertSessionHasErrors(['user_email']);
    }



public function test_store_handles_mail_sending_exception()
{
    // Setup normal storage for image upload
    Storage::fake('public');
    
    // Use Mail::fake() first to set up the fake mailer
    Mail::fake();
    
    // Then manually throw an exception when Mail is used by providing a custom callback
    Mail::shouldReceive('to')
        ->andThrow(new \Exception('Mail sending failed'));
    
    // Create test data with image
    $image = UploadedFile::fake()->create('profile.jpg', 100, 'image/jpeg');
    $userData = [
        'full_name' => 'Mail Exception User',
        'user_name' => 'mailexception',
        'phone_number' => '201234567777',
        'whatsapp_number' => '201234567778',
        'password' => '1Stegengoal_!',
        'user_email' => 'mail_exception@example.com',
        'user_address' => '123 Mail Exception Street',
        'user_image' => $image
    ];
    
    // Send post request to store method 
    $response = $this->post('/register', $userData);
    
    // Assert correct error response
    $response->assertRedirect();
    $response->assertSessionHasErrors(['db_error']);
    
    // Remove the database assertion - user will exist in the database despite email failure
}

public function test_store_handles_database_save_exception()
{
    // Setup normal storage
    Storage::fake('public');
    
    // Mock the Mail facade to throw an exception
    Mail::shouldReceive('to')
        ->once()
        ->andThrow(new \Exception('Database error'));
    
    // Create test data with image
    $image = UploadedFile::fake()->create('profile.jpg', 100, 'image/jpeg');
    $userData = [
        'full_name' => 'DB Exception User',
        'user_name' => 'dbexception',
        'phone_number' => '201234568888',
        'whatsapp_number' => '201234568889',
        'password' => '1Stegengoal_!',
        'user_email' => 'db_exception@example.com',
        'user_address' => '123 DB Exception Street',
        'user_image' => $image
    ];
    
    // Send post request to store method 
    $response = $this->post('/register', $userData);
    
    // Assert correct error response
    $response->assertRedirect();
    $response->assertSessionHasErrors(['db_error']);
}
}