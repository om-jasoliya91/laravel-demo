<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:users,email',
            'age' => 'required|integer|min:15|max:35',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'password' => 'required|string|min:6|confirmed',
            'profile_pic' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // File upload
        if ($request->hasFile('profile_pic')) {
            $validated['profile_pic'] =
                $request->file('profile_pic')->store('uploads', 'public');
        }

        // Hash password
        $validated['password'] = bcrypt($validated['password']);

        // Create user
        $user = User::create($validated);

        // Sanctum token
        // $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'data' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => new UserResource($user),
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }

    public function fetchUser(Request $request)
    {
        return new UserResource($request->user());
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();  // current logged-in user

        $request->validate([
            'name' => 'required|string|min:2|max:255',
            'age' => 'nullable|integer|min:15|max:35',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload new profile image
        if ($request->hasFile('profile_pic')) {
            // delete old image (optional but recommended)
            if ($user->profile_pic && file_exists(storage_path('app/public/' . $user->profile_pic))) {
                unlink(storage_path('app/public/' . $user->profile_pic));
            }

            $user->profile_pic = $request->file('profile_pic')->store('uploads', 'public');
        }

        // Update fields
        $user->update([
            'name' => $request->name,
            'age' => $request->age,
            'city' => $request->city,
            'address' => $request->address,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data' => new UserResource($user),  // return updated user
        ]);
    }

    public function deleteUserAccount(Request $request)
    {
        $user = $request->user();

        // delete profile image
        if ($user->profile_pic && file_exists(storage_path('app/public/' . $user->profile_pic))) {
            unlink(storage_path('app/public/' . $user->profile_pic));
        }

        // delete only the current logged-in token
        $user->currentAccessToken()->delete();

        // delete user from DB
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Account deleted successfully'
        ]);
    }
}
