<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function adminDashboardView()
    {
        $totalUsers = User::count();
        $totalCourses = Course::count();
        $totalEnrollments = Enrollment::count();
        return view('admin.dashboard', compact('totalUsers', 'totalCourses', 'totalEnrollments'));
    }

    // Show Add Student Form
    public function studentAdd()
    {
        return view('admin.studentAdd');
    }

    // Store Student
    public function studentsStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:users,email',
            'age' => 'required|integer|min:15|max:35',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'password' => 'required|string|min:6|confirmed',
            'profile_pic' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 1;  // Student role

        // Handle profile upload
        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads', $filename, 'public');
            $validated['profile_pic'] = $path;
        }

        User::create($validated);

        return redirect()->route('admin.studentAdd')->with('success', 'Student added successfully.');
    }

    // View all students
    public function studentView()
    {
        $students = User::where('role', 1)->get();
        return view('admin.studentView', compact('students'));
    }

    public function studentEditView($id)
    {
        $students = User::findOrFail($id);
        return view('admin.studentEdit', compact('students'));
    }

    public function studentEdit(Request $request, $id)
    {
        $student = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:users,email,' . $student->id,
            'age' => 'required|integer|min:15|max:35',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'profile_pic' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        $student->fill($validated);

        if ($request->hasFile('profile_pic')) {
            if ($student->profile_pic && Storage::disk('public')->exists($student->profile_pic)) {
                Storage::disk('public')->delete($student->profile_pic);
            }

            $file = $request->file('profile_pic');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads', $filename, 'public');
            $student->profile_pic = $path;
        }

        $student->save();

        return redirect()->route('admin.studentView')->with('success', 'Student updated successfully.');
    }

    public function delete($id)
    {
        $student = User::findOrFail($id);

        if ($student->profile_pic && Storage::disk('public')->exists($student->profile_pic)) {
            Storage::disk('public')->delete($student->profile_pic);
        }

        $student->delete();

        return redirect()->route('admin.studentView')->with('success', 'Student deleted successfully.');
    }

    // View Enrollments
    public function enrollView()
    {
        $enrollments = Enrollment::with(['user', 'course'])->get();
        return view('admin.enrollView', compact('enrollments'));
    }

    // Accept Enrollment
    public function acceptEnrollment($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->update(['status' => 'accept']);
        return redirect()->back()->with('success', 'Enrollment accepted successfully.');
    }

    // Decline Enrollment
    public function declineEnrollment($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->update(['status' => 'decline']);
        return redirect()->back()->with('success', 'Enrollment declined successfully.');
    }
}
