<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Notifications\AdminNewEnrollment;
use App\Notifications\EnrollmentStatusChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function dashboardView()
    {
        $userId = session('user_id');
        $user = User::findOrFail($userId);

        $totalCourses = Course::count();
        $enrollmentsCount = Enrollment::where('user_id', $userId)->count();

        $notifications = $user->unreadNotifications()->latest()->take(5)->get();

        return view('student.dashboard', compact('user','totalCourses','enrollmentsCount','notifications'));
    }

    public function myEnrollments()
    {
        $userId = session('user_id');
        $user = User::findOrFail($userId);

        $enrollments = Enrollment::with('course')
            ->where('user_id', $userId)
            ->get();

        return view('student.profile', compact('user', 'enrollments'));
    }

    public function editViewProfile($id)
    {
        $userId = session('user_id');
        $user = User::findOrFail($userId);
        return view('student.editProfile', compact('user'));
    }

    public function editProfile(Request $request, $id)
    {
        $userId = session('user_id');
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
            $path = $request->file('profile_pic')->store('uploads', 'public');
            $validated['profile_pic'] = $path;
        }

        $user->update($validated);

        return redirect()->route('student.profile')->with('success', 'Profile updated.');
    }

    public function studentViewCourse()
    {
        $userId = session('user_id');
        $courses = Course::all();
        $enrollments = Enrollment::where('user_id', $userId)
            ->pluck('status', 'course_id')->toArray();

        return view('student.course', compact('courses','enrollments'));
    }

    public function enroll($courseId)
    {
        $userId = session('user_id');
        $user = User::findOrFail($userId);
        $course = Course::findOrFail($courseId);

        if (Enrollment::where('user_id', $user->id)->where('course_id', $course->id)->exists()) {
            return redirect()->back()->with('error', 'Already applied.');
        }

        $enrollment = Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'pending',
        ]);

        // Notify admins
        $admins = User::where('role', 0)->get();
        foreach ($admins as $admin) {
            $admin->notify(new AdminNewEnrollment($enrollment));
        }

        return redirect()->back()->with('success', 'Enrollment requested!');
    }

    public function notifications()
    {
        $userId = session('user_id');
        $user = User::findOrFail($userId);

        $notifications = $user->unreadNotifications()->latest()->get();

        return view('student.notification', compact('notifications'));
    }
}
