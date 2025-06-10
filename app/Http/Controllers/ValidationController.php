<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ValidationController extends Controller
{
    public function checkUsername(Request $request) {
        $exists = User::where('user_name', $request->input('user_name'))->exists();
        return response($exists ? 'Username already taken' : '');
    }

    public function checkPhone(Request $request) {
        // Change 'phone' to 'phone_number'
        $exists = User::where('phone_number', $request->input('phone_number'))->exists();
        return response($exists ? 'Phone number already in use' : '');
    }

    public function checkEmail(Request $request) {
        // Change 'email' to 'user_email'
        $exists = User::where('user_email', $request->input('user_email'))->exists();
        return response($exists ? 'Email already in use' : '');
    }

    public function checkWhatsApp(Request $request) {
        // Change 'whatsapp' to 'whatsapp_number'
        try {
            // Check if the number exists in database
            $exists = User::where('whatsapp_number', $request->input('whatsapp_number'))->exists();
            
            // Return a message only if number exists
            return response($exists ? 'WhatsApp number already in use' : '');
        } catch (\Exception $e) {
            \Log::error('WhatsApp validation error: ' . $e->getMessage());
            return response('Error checking WhatsApp number', 500);
        }
    }
}