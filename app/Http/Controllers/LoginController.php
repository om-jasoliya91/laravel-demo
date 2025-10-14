<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

            // Redirect by role
            if ($user->role == 0) {
                return redirect()->route('admin.dashboard')->with('success', 'Welcome Admin!');
            } else {
                return redirect()->route('student.dashboard')->with('success', 'Welcome Student!');
            }
        }

        return redirect()->back()->with('error', 'Invalid email or password.');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login.view')->with('success', 'You have logged out successfully.');
    }
}
