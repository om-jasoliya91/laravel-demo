<?php

use App\Http\Controllers\AdminController;
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

Route::middleware(['authCheck'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'adminDashboardView'])->name('admin.dashboard');
    Route::get('admin/studentAdd', [AdminController::class, 'studentAdd'])->name('admin.studentAdd');
    Route::post('admin/studentAdd', [AdminController::class, 'studentsStore'])->name('admin.studentStore');
    Route::get('admin/studentView', [AdminController::class, 'studentView'])->name('admin.studentView');

    Route::get('admin/studentEdit/{id}', [AdminController::class, 'studentEditView'])->name('admin.studentEditView');
    Route::post('admin/studentEdit/{id}', [AdminController::class, 'studentEdit'])->name('admin.studentEdit');

    Route::delete('admin/studentDelete/{id}', [AdminController::class, 'delete'])->name('admin.studentDelete');

    Route::get('student/dashboard', [UserController::class, 'dashboardView'])->name('student.dashboard');
});
