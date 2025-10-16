@extends('layouts.student')
@section('title', 'Profile')

@section('content')
<div class="container my-5">
    <h2 class="mb-4 text-center">My Profile & Enrollments</h2>

    <!-- Profile Card -->
    @if ($user)
        <div class="card mb-5 shadow-sm text-center">
            <div class="card-body">
                <img src="{{ asset('storage/' . $user->profile_pic) }}" class="rounded-circle mb-3" width="120" height="120">
                <h4>{{ $user->name }}</h4>
                <p class="text-muted">{{ $user->email }}</p>
                <div class="d-flex justify-content-center gap-4 mt-3">
                    <div><strong>Age:</strong> {{ $user->age ?? '-' }}</div>
                    <div><strong>City:</strong> {{ $user->city ?? '-' }}</div>
                    <div><strong>Address:</strong> {{ $user->address ?? '-' }}</div>
                </div>
                <a href="{{ route('student.editProfile', $user->id) }}" class="btn btn-primary btn-sm mt-3">Edit Profile</a>
            </div>
        </div>
    @endif

    <!-- Enrollments Table -->
    <h4 class="mb-3">My Enrollments</h4>
    @if ($enrollments->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Course</th>
                        <th>Code</th>
                        <th>Duration</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($enrollments as $enroll)
                        <tr>
                            <td>{{ $enroll->course->name ?? '-' }}</td>
                            <td>{{ $enroll->course->code ?? '-' }}</td>
                            <td>{{ $enroll->course->duration ?? '-' }}</td>
                            <td>
                                @switch($enroll->status)
                                    @case('pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                        @break
                                    @case('accept')
                                        <span class="badge bg-success">Accepted</span>
                                        @break
                                    @case('decline')
                                        <span class="badge bg-danger">Declined</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ $enroll->status }}</span>
                                @endswitch
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-center text-muted">You have no enrollments yet.</p>
    @endif
</div>
@endsection
