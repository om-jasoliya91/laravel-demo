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

    public function courseStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:courses,code',
            'duration' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive',
        ]);

        Course::create($validated);

        return redirect()->route('admin.viewCourse')->with('success', 'Course added.');
    }

    public function viewCourse()
    {
        $courses = Course::all();
        return view('admin.viewCourse', compact('courses'));
    }

    public function editViewCourse($id)
    {
        $course = Course::findOrFail($id);
        return view('admin.editCourse', compact('course'));
    }

    public function editCourse(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:courses,code,'.$course->id,
            'duration' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive',
        ]);

        $course->update($validated);

        return redirect()->route('admin.viewCourse')->with('success', 'Course updated.');
    }

    public function courseDelete($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return redirect()->back()->with('success', 'Course deleted.');
    }
}
