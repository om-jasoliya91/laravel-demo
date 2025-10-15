@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
<div class="container my-5">
    <h2>Welcome, {{ session('user_name') }}</h2>

    <div class="row">
        <!-- Total Users -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-primary h-100">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text display-6">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>

        <!-- Total Courses -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-success h-100">
                <div class="card-body">
                    <h5 class="card-title">Total Courses</h5>
                    <p class="card-text display-6">{{ $totalCourses }}</p>
                </div>
            </div>
        </div>

        <!-- Total Enrollments -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-warning h-100">
                <div class="card-body">
                    <h5 class="card-title">Total Enrollments</h5>
                    <p class="card-text display-6">{{ $totalEnrollments }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
