<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    // Show the forgot password form
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    // Handle sending password reset link

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'success' => true,
                'message' => 'Password reset link sent to your email!',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Unable to send reset link.'
        ], 422);
    }
}
