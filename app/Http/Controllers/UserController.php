<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Dashboard view
    public function dashboardView()
    {
        return view('student.dashboard');
    }

    // Edit profile form
    public function editViewProfile($id)
    {
        $userId = session('user_id');
        if (!$userId) {
            return redirect()->route('login.view')->with('error', 'Please login first.');
        }

        $user = User::findOrFail($id);
        return view('student.editProfile', compact('user'));
    }

    // Update profile
    public function editProfile(Request $request, $id)
    {
        $userId = session('user_id');
        if (!$userId) {
            return redirect()->route('login.view')->with('error', 'Please login first.');
        }

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

    // View all courses with enrollment status
    public function studentViewCourse()
    {
        $userId = session('user_id');
        if (!$userId) {
            return redirect()->route('login.view')->with('error', 'Please login first.');
        }

        $courses = Course::all();
        $enrollments = Enrollment::where('user_id', $userId)
            ->pluck('status', 'course_id')
            ->toArray();

        return view('student.course', compact('courses', 'enrollments'));
    }

    // Enroll in a course
    public function enroll($courseId)
    {
        $userId = session('user_id');
        if (!$userId) {
            return redirect()->route('login.view')->with('error', 'Please login first.');
        }

        $user = User::findOrFail($userId);
        $course = Course::findOrFail($courseId);

        if ($course->status !== 'active') {
            return redirect()->back()->with('error', 'Cannot enroll in inactive course.');
        }

        $existing = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Already applied for this course.');
        }

        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Enrollment request submitted!');
    }

    // Show current user's profile & enrollments
    public function myEnrollments()
    {
        $userId = session('user_id');
        if (!$userId) {
            return redirect()->route('login.view')->with('error', 'Please login first.');
        }

        $user = User::findOrFail($userId);
        $enrollments = Enrollment::with('course')
            ->where('user_id', $user->id)
            ->get();

        return view('student.profile', compact('user', 'enrollments'));
    }
}
