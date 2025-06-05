<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function store(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'user_name' => 'required|unique:users,user_name',
            'phone_number' => 'required|unique:users,phone_number',
            'whatsapp_number' => 'required|unique:users,whatsapp_number',
            'user_password' => 'required|string|min:6',
            'user_email' => 'required|email|unique:users,user_email',
            'user_address' => 'required|string',
            'user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Handle file upload
        $imageName = null;
        if ($request->hasFile('user_image')) {
            $imageName = time() . '.' . $request->user_image->extension();
            $request->user_image->move(public_path('uploads'), $imageName);
        }

        // Save user to database
        $user = new User();
        $user->full_name = $request->full_name;
        $user->user_name = $request->user_name;
        $user->phone_number = $request->phone_number;
        $user->whatsapp_number = $request->whatsapp_number;
        $user->user_password = Hash::make($request->user_password);
        $user->user_email = $request->user_email;
        $user->user_address = $request->user_address;
        $user->user_image = $imageName;
        $user->save();

        return redirect('/')->with('success', 'Registration successful!');
    }
}