<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // Show login form
    public function loginView()
    {
        return view('login');
    }

    // Authenticate user/admin
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:0,1',  // 0 = admin, 1 = student
        ]);

        // Find user with matching email and role
        $user = User::where('email', $request->email)
            ->where('role', $request->role)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', 'Invalid credentials.');
        }

        // Set session based on role
        if ($user->role == 0) {
            $request->session()->put('admin_id', $user->id);
            $request->session()->put('admin_name', $user->name);
            return redirect()->route('admin.dashboard');
        }

        if ($user->role == 1) {
            $request->session()->put('student_id', $user->id);
            $request->session()->put('student_name', $user->name);
            return redirect()->route('student.dashboard');
        }
    }

    public function logout(Request $request)
    {
        if ($request->session()->has('admin_id')) {
            $request->session()->forget(['admin_id', 'admin_name', 'user_role']);
        } elseif ($request->session()->has('student_id')) {
            $request->session()->forget(['student_id', 'student_name', 'user_role']);
        }

        return redirect()->route('login.view')->with('success', 'Logged out successfully.');
    }
}
