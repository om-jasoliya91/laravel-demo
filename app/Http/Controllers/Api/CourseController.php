<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function allCourse()
    {
        return CourseResource::collection(Course::all());
    }

    public function enrollCourses(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        $user = $request->user();

        // Prevent duplicate enroll
        if (Enrollment::where('user_id', $user->id)
                ->where('course_id', $request->course_id)
                ->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Already enrolled in this course'
            ], 409);
        }

        // Store enrollment (status default = pending)
        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $request->course_id,
            'status' => 'pending',  // optional because default is pending
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Course applied successfully (status: pending)'
        ]);
    }
}
