<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use App\Notifications\EnrollmentStatusChanged;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class AdminController extends Controller
{
    // Dashboard
    public function adminDashboardView()
    {
        // Counts
        $totalUsers = User::where('role', 1)->count();  // only students
        $totalCourses = Course::count();
        $totalEnrollments = Enrollment::count();

        // Get admin from session
        $adminId = session('admin_id');  // <-- use admin_id, not user_id
        $admin = User::find($adminId);

        // Get notifications if admin exists
        $notifications = collect();
        if ($admin && $admin->role === 0) {
            $notifications = $admin->unreadNotifications()->latest()->take(5)->get();
        }

        return view('admin.dashboard', compact('totalUsers', 'totalCourses', 'totalEnrollments', 'notifications'));
    }

    // Show all students
    public function studentView()
    {
        $students = User::where('role', 1)->get();
        return view('admin.studentView', compact('students'));
    }

    public function studentAdd()
    {
        return view('admin.studentAdd');
    }

    public function studentsStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 1,  // student
        ]);

        return redirect()->route('admin.studentView')->with('success', 'Student added successfully.');
    }

    public function studentEditView($id)
    {
        $student = User::findOrFail($id);
        return view('admin.studentEdit', compact('student'));
    }

    public function studentEdit(Request $request, $id)
    {
        $student = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->id,
        ]);

        $student->update($validated);

        return redirect()->route('admin.studentView')->with('success', 'Student updated successfully.');
    }

    public function delete($id)
    {
        $student = User::findOrFail($id);
        $student->delete();
        return redirect()->back()->with('success', 'Student deleted successfully.');
    }

    public function __construct()
    {
        Paginator::useBootstrap();
    }

    // Enrollments
    public function enrollView()
    {
        $enrollments = Enrollment::with(['user', 'course'])->paginate(5);
        return view('admin.enrollView', compact('enrollments'));
    }

    public function acceptEnrollment($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->update(['status' => 'accept']);
        $enrollment->user->notify(new EnrollmentStatusChanged($enrollment));

        return redirect()->back()->with('success', 'Enrollment accepted.');
    }

    public function declineEnrollment($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->update(['status' => 'decline']);
        $enrollment->user->notify(new EnrollmentStatusChanged($enrollment));

        return redirect()->back()->with('success', 'Enrollment declined.');
    }
}
