<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthCheck
{
    public function handle(Request $request, Closure $next): Response
    {
        $isAdminRoute = $request->is('admin/*');
        $isStudentRoute = $request->is('student/*');

        $userRole = $request->session()->get('user_role');
        $isLoggedIn = $request->session()->has('user_id');

        if (!$isLoggedIn) {
            return redirect()->route('login.view')->with('error', 'Please login first.');
        }

        if ($isAdminRoute && $userRole != 0) {
            return redirect()->route('login.view')->with('error', 'Access denied: Admins only.');
        }

        if ($isStudentRoute && $userRole != 1) {
            return redirect()->route('login.view')->with('error', 'Access denied: Students only.');
        }

        $response = $next($request);

        return $response
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}
