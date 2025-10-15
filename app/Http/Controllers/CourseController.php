<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function courseAddView()
    {
        return view('admin.addCourse');
    }

    public function viewCourse()
    {
        $courses = Course::all();
        // echo '<pre>';
        // print_r($courses);
        // echo '</pre>';
        // exit;
        return view('admin.viewCourse', compact('courses'));
    }

    public function courseStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2|unique:courses,name',
            'code' => 'required|string|unique:courses,code',
            'description' => 'required|string',
            'duration' => 'required|string',
            'price' => 'required|numeric',
            'status' => 'required|in:active,inactive',
        ]);
        Course::create($validated);
        return redirect('admin/addCourse')->with('success', 'Course added successfully.');
    }

    public function courseDelete($id)
    {
        $course = Course::findOrFail($id);

        $course->delete();

        return redirect()->route('admin.viewCourse')->with('success', 'Student deleted successfully.');
    }

    public function editViewCourse($id)
    {
        $courses = Course::findOrFail($id);
        return view('admin.editCourse', compact('courses'));
    }

    public function editCourse(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|min:2|unique:courses,name,' . $id,
            'code' => 'required|string|unique:courses,code,' . $id,
            // 'name' => 'required|string|min:2|unique:courses,name,' . $id,
            // 'code' => 'required|string|unique:courses,code,' . $id,
            'description' => 'required|string',
            'duration' => 'required|string',
            'price' => 'required|numeric',
            'status' => 'required|in:active,inactive',
        ]);
        // Update course
        $course->update($validated);

        return redirect()->route('admin.viewCourse')->with('success', 'Course updated successfully!');
    }


}
