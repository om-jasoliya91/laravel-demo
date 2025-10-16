@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
@php
    // Determine role and name
    if(session()->has('admin_id')) {
        $role = 0;
        $name = session('admin_name');
        $totalUsers = $totalUsers ?? 0;
        $totalCourses = $totalCourses ?? 0;
        $totalEnrollments = $totalEnrollments ?? 0;
        $notifications = $notifications ?? collect();
    } elseif(session()->has('student_id')) {
        $role = 1;
        $name = session('student_name');
        $totalCourses = $totalCourses ?? 0;
        $enrollmentsCount = $enrollmentsCount ?? 0;
        $notifications = $notifications ?? collect();
    } else {
        $role = null;
        $name = 'Guest';
    }
@endphp

<div class="container my-5">
    <h2 class="mb-4">Welcome, {{ $name }}</h2>

    @if($role === 0)
        <!-- Admin Dashboard -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary h-100">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <p class="card-text display-6">{{ $totalUsers }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success h-100">
                    <div class="card-body">
                        <h5 class="card-title">Total Courses</h5>
                        <p class="card-text display-6">{{ $totalCourses }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning h-100">
                    <div class="card-body">
                        <h5 class="card-title">Total Enrollments</h5>
                        <p class="card-text display-6">{{ $totalEnrollments }}</p>
                    </div>
                </div>
            </div>
        </div>

        <h4>Notifications</h4>
        <ul class="list-group mb-4">
            @forelse($notifications as $notification)
                <li class="list-group-item">
                    {{ $notification->data['message'] }}
                    <small class="text-muted float-end">{{ $notification->created_at->diffForHumans() }}</small>
                </li>
            @empty
                <li class="list-group-item text-muted">No new notifications</li>
            @endforelse
        </ul>

    @elseif($role === 1)
        <!-- Student Dashboard -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card text-white bg-success h-100">
                    <div class="card-body">
                        <h5 class="card-title">Total Courses Available</h5>
                        <p class="card-text display-6">{{ $totalCourses }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-white bg-warning h-100">
                    <div class="card-body">
                        <h5 class="card-title">Your Enrollments</h5>
                        <p class="card-text display-6">{{ $enrollmentsCount }}</p>
                    </div>
                </div>
            </div>
        </div>

        <h4>Notifications</h4>
        <ul class="list-group mb-4">
            @forelse($notifications as $notification)
                <li class="list-group-item">
                    {{ $notification->data['message'] }}
                    <small class="text-muted float-end">{{ $notification->created_at->diffForHumans() }}</small>
                </li>
            @empty
                <li class="list-group-item text-muted">No new notifications</li>
            @endforelse
        </ul>

    @else
        <!-- Guest -->
        <p class="text-center text-muted">You are not logged in.</p>
    @endif
</div>
@endsection
