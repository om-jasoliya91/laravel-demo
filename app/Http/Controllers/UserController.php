<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function dashboardView()
    {
        return view('student.dashboard');
    }

    public function profileView(Request $request)
    {
        $userId = $request->session()->get('user_id');

        if (!$userId) {
            return redirect()->route('login.view')->with('error', 'Please login first.');
        }

        $users = User::find($userId);

        if (!$users) {
            return redirect()->route('login.view')->with('error', 'User not found.');
        }
        // echo "<pre>";
        // print_r($user);
        // echo "</pre>";
        // exit;
        return view('student.profile', compact('users'));
    }

    public function editViewProfile($id)
    {
        $user = User::findOrFail($id);
        // echo '<pre>';
        // print_r($user);
        // echo '</pre>';
        // exit;
        return view('student.editProfile', compact('user'));
    }

    public function editProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'age' => 'nullable|integer|min:15',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'profile_pic' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);
        if ($request->hasFile('profile_pic')) {
            if ($user->profile_pic && Storage::disk('public')->exists($user->profile_pic)) {
                Storage::disk('public')->delete($user->profile_pic);
            }
            $file = $request->file('profile_pic');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads', $filename, 'public');
            $validated['profile_pic'] = $path;
        }
        $user->update($validated);
        return redirect()->route('student.profile')->with('success', 'Profile updated successfully.');
    }
}
