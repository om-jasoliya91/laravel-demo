<?php
namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Closure;

class AuthCheck
{
    public function handle(Request $request, Closure $next): Response
    {
        $isAdminRoute = $request->is('admin/*');
        $isStudentRoute = $request->is('student/*');

        if ($isAdminRoute && !$request->session()->has('admin_id')) {
            return redirect()->route('login.view')->with('error', 'Please login as admin.');
        }

        if ($isStudentRoute && !$request->session()->has('student_id')) {
            return redirect()->route('login.view')->with('error', 'Please login as student.');
        }

        $response = $next($request);

        return $response
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}
