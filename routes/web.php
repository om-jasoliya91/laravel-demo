<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/register', [RegisterController::class, 'registerView']);
// Route::post('/register', [RegisterController::class, 'registerAdd'])->name('register.post');

Route::get('/register', [RegisterController::class, 'registerView'])->name('register.view');
Route::post('/register', [RegisterController::class, 'registerAdd'])->name('register.post');

// Login Routes
Route::get('/login', [LoginController::class, 'loginView'])->name('login.view');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('student/dashboard', [UserController::class, 'dashboardView']);

Route::middleware(['authCheck'])->prefix('admin')->group(function () {
    Route::get('dashboard', [AdminController::class, 'adminDashboardView'])->name('admin.dashboard');
    Route::get('studentAdd', [AdminController::class, 'studentAdd'])->name('admin.studentAdd');
    Route::post('studentAdd', [AdminController::class, 'studentsStore'])->name('admin.studentStore');
    Route::get('studentView', [AdminController::class, 'studentView'])->name('admin.studentView');

    Route::get('studentEdit/{id}', [AdminController::class, 'studentEditView'])->name('admin.studentEditView');
    Route::post('studentEdit/{id}', [AdminController::class, 'studentEdit'])->name('admin.studentEdit');

    Route::delete('studentDelete/{id}', [AdminController::class, 'delete'])->name('admin.studentDelete');

    Route::get('addCourse', [CourseController::class, 'courseAddView'])->name('admin.addCourse');
    Route::post('addCourse', [CourseController::class, 'courseStore'])->name('admin.courseStore');
    Route::delete('courseDelete/{id}', [CourseController::class, 'courseDelete'])->name('admin.courseDelete');

    Route::get('viewCourse', [CourseController::class, 'viewCourse'])->name('admin.viewCourse');

    Route::get('editCourse/{id}', [CourseController::class, 'editViewCourse'])->name('admin.editCourse');
    Route::post('editCourse/{id}', [CourseController::class, 'editCourse'])->name('admin.editCourse');

});

Route::middleware(['authCheck'])->prefix('student')->group(function () {
    Route::get('dashboard', [UserController::class, 'dashboardView'])->name('student.dashboard');
});
