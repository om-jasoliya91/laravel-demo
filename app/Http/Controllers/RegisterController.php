<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function registerView()
    {
        return view('register'); // Blade view
    }

    public function registerAdd(Request $request)
    {
        // Validate form
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:users,email',
            'age' => 'required|integer|min:15|max:35',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'password' => 'required|string|min:6|confirmed',
            'profile_pic' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        // Hash password
        $validated['password'] = Hash::make($validated['password']);

        // Handle profile upload
        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads', $filename, 'public');
            $validated['profile_pic'] = $path;
        }

        // Default role = 1 (user)
        $validated['role'] = 1;

        // Save user
        User::create($validated);

        return redirect()->back()->with('success', 'Congratulations! Your account has been created successfully.');
    }
}
