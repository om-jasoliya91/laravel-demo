<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function allCourse()
    {
        return CourseResource::collection(Course::all());
    }

    public function courseUpdate(Request $request)
    {
        $user = $request->user();

        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'age' => 'nullable|integer',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Update normal fields
        $user->name = $request->name;
        $user->email = $request->email;
        $user->age = $request->age;
        $user->city = $request->city;
        $user->address = $request->address;

        if ($request->hasFile('profile_pic')) {
            // Delete old file if exists
            if ($user->profile_pic && Storage::disk('public')->exists($user->profile_pic)) {
                Storage::disk('public')->delete($user->profile_pic);
            }

            // Upload new file to storage/app/public/uploads
            $path = $request->file('profile_pic')->store('uploads', 'public');
            $user->profile_pic = $path;
        }
        // If no image uploaded → keep old one

        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully',
            'data' => [
                ...$user->toArray(),
                'profile_pic_url' => $user->profile_pic
                    ? asset('storage/' . $user->profile_pic)
                    : null
            ]
        ]);
    }
}
