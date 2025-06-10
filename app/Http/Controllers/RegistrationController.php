<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserRegistered;

class RegistrationController extends Controller
{
    public function store(Request $request)
    {
        // Validate input (this will auto redirect back with errors if validation fails)
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'user_name' => 'required|unique:users,user_name',
            'phone_number' => 'required|unique:users,phone_number',
            'whatsapp_number' => 'required|unique:users,whatsapp_number',
            'password' => 'required|string|min:8',
            'user_email' => 'required|email|unique:users,user_email',
            'user_address' => 'required|string',
            'user_image' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        $imagePath = null;
        if ($request->hasFile('user_image')) {
            // Add debugging
            \Log::info('Image upload attempt started');
            \Log::info('File details: ', [
                'name' => $request->file('user_image')->getClientOriginalName(),
                'size' => $request->file('user_image')->getSize(),
                'mime' => $request->file('user_image')->getMimeType()
            ]);
            
            try {
                $imagePath = $request->file('user_image')->store('uploads', 'public');
                \Log::info('Image uploaded successfully: ' . $imagePath);
            } catch (\Exception $e) {
                \Log::error('Image upload failed: ' . $e->getMessage());
                return back()->withErrors(['user_image' => 'Image upload failed: ' . $e->getMessage()])
                            ->withInput();
            }
        }

        // Create and save user
        $user = new User();
        $user->full_name = $validated['full_name'];
        $user->user_name = $validated['user_name'];
        $user->phone_number = $validated['phone_number'];
        $user->whatsapp_number = $validated['whatsapp_number'];
        // $user->password = bcrypt($validated['password']);
        $user->password = Crypt::encrypt($validated['password']);
        $user->user_email = $validated['user_email'];
        $user->user_address = $validated['user_address'];
        $user->user_image = $imagePath;

        try {
            $user->save();
            Mail::to(env('ADMIN_EMAIL', 'regist.laravel@gmail.com'))->send(new NewUserRegistered($user->user_name));
            //Mail::to($user->user_email)->send(new NewUserRegistered($user->user_name));
        } catch (\Exception $e) {
            return back()->withErrors(['db_error' => 'Failed to save user'])
                        ->withInput();
        }

        // Redirect with success message
        return redirect('/')->with([
            'success' => 'Registration successful!',
            'user_first_name' => ucfirst(strtolower(explode(' ', $user->full_name)[0])),
        ]);
    }
}