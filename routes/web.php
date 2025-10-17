<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

// Welcome
Route::get('/', fn() => view('welcome'));

// Register & Login
Route::get('/register', [RegisterController::class, 'registerView'])->name('register.view');
Route::post('/register', [RegisterController::class, 'registerAdd'])->name('register.post');

Route::get('/login', [LoginController::class, 'loginView'])->name('login.view');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

// Send reset link
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Show reset password form
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

// Handle password reset
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// ------------------ Admin Routes ------------------
Route::middleware(['authCheck:admin'])->prefix('admin')->group(function () {
    Route::get('dashboard', [AdminController::class, 'adminDashboardView'])->name('admin.dashboard');

    // Students
    Route::get('studentAdd', [AdminController::class, 'studentAdd'])->name('admin.studentAdd');
    Route::post('studentAdd', [AdminController::class, 'studentsStore'])->name('admin.studentStore');
    Route::get('studentView', [AdminController::class, 'studentView'])->name('admin.studentView');
    Route::get('studentEdit/{id}', [AdminController::class, 'studentEditView'])->name('admin.studentEditView');
    Route::post('studentEdit/{id}', [AdminController::class, 'studentEdit'])->name('admin.studentEdit');
    Route::delete('studentDelete/{id}', [AdminController::class, 'delete'])->name('admin.studentDelete');

    // Courses
    Route::get('addCourse', [CourseController::class, 'courseAddView'])->name('admin.addCourse');
    Route::post('addCourse', [CourseController::class, 'courseStore'])->name('admin.courseStore');
    Route::get('viewCourse', [CourseController::class, 'viewCourse'])->name('admin.viewCourse');
    Route::get('editCourse/{id}', [CourseController::class, 'editViewCourse'])->name('admin.editCourse');
    Route::post('editCourse/{id}', [CourseController::class, 'editCourse'])->name('admin.editCourse');
    Route::delete('courseDelete/{id}', [CourseController::class, 'courseDelete'])->name('admin.courseDelete');

    // Enrollments
    Route::get('enrollView', [AdminController::class, 'enrollView'])->name('admin.enrollView');
    Route::post('enrollment/accept/{id}', [AdminController::class, 'acceptEnrollment'])->name('admin.enrollment.accept');
    Route::post('enrollment/decline/{id}', [AdminController::class, 'declineEnrollment'])->name('admin.enrollment.decline');
});

// ------------------ Student Routes ------------------
Route::middleware(['authCheck:student'])->prefix('student')->group(function () {
    Route::get('dashboard', [UserController::class, 'dashboardView'])->name('student.dashboard');

    Route::get('profile', [UserController::class, 'myEnrollments'])->name('student.profile');
    Route::get('editProfile/{id}', [UserController::class, 'editViewProfile'])->name('student.editProfile');
    Route::post('editProfile/{id}', [UserController::class, 'editProfile'])->name('student.updateProfile');

    Route::get('course', [UserController::class, 'studentViewCourse'])->name('student.course');
    Route::post('course/{course}', [UserController::class, 'enroll'])->name('student.enroll');

    Route::get('notifications', [UserController::class, 'notifications'])->name('student.notifications');
});

// Route::get('/session-debug', function () {
//     $sessionFiles = \File::files(storage_path('framework/sessions'));
//     $latestFile = end($sessionFiles);
//     $payload = file_get_contents($latestFile);
//     $data = unserialize($payload);
//     dd($data);
// });

// Route::get('/session-view', function () {
//     // Get all session data
//     $all = session()->all();

//     dd($all);
// });
