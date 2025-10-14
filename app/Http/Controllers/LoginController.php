<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function loginView()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Store session data
            $request->session()->put('user_id', $user->id);
            $request->session()->put('user_name', $user->name);
            $request->session()->put('user_role', $user->role);

            // Role-based redirect
            if ($user->role == 0) {
                return redirect('/admin/dashboard')->with('success', 'Admin Login Successful');
            } else {
                return redirect('/student/dashboard')->with('success', 'Login Successful');
            }
        }

        return redirect()->back()->with('error', 'Email and password do not match');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();  // remove all session data
        return redirect('/login')->with('success', 'Logged out successfully');
    }
}
