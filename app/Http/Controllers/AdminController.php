<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function adminDashboardView()
    {
        return view('admin.dashboard');
    }

    // Show Add Student form
    public function studentAdd()
    {
        return view('admin.studentAdd');  // create this blade file
    }

    // Handle Add Student form submission
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
        $validated['role'] = 1;  // student role

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
        //         echo "<pre>";
        // print_r($students);
        // echo "</pre>";
        // exit;
        return view('admin.studentView', compact('students'));  // create this blade file
    }

    public function studentEditView($id)
    {
        $students = User::findOrFail($id);
        //         echo "<pre>";
        // print_r($students);
        // echo "</pre>";
        // exit;
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

        $student->name = $validated['name'];
        $student->email = $validated['email'];
        $student->age = $validated['age'];
        $student->city = $validated['city'];
        $student->address = $validated['address'];

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
}
