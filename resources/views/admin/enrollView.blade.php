@extends('layouts.main')
@section('title', 'Enrollments')
@section('content')

    <div class="container my-5">
        <h2 class="mb-4">Enrollment Requests</h2>

        {{-- Success/Error Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Enrollment ID</th>
                    <th>User ID</th>
                    <th>User Name</th>
                    <th>User Email</th>
                    <th>Course ID</th>
                    <th>Course Name</th>
                    <th>Course Code</th>
                    <th>Course Duration</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($enrollments as $enrollment)
                    <tr>
                        <td>{{ $enrollment->id }}</td>
                        <td>{{ $enrollment->user->id }}</td>
                        <td>{{ $enrollment->user->name }}</td>
                        <td>{{ $enrollment->user->email }}</td>
                        <td>{{ $enrollment->course->id }}</td>
                        <td>{{ $enrollment->course->name }}</td>
                        <td>{{ $enrollment->course->code }}</td>
                        <td>{{ $enrollment->course->duration }}</td>

                        <td>
                            @if ($enrollment->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($enrollment->status == 'accept')
                                <span class="badge bg-success">Accepted</span>
                            @elseif($enrollment->status == 'decline')
                                <span class="badge bg-danger">Declined</span>
                            @endif
                        </td>

                        <td>
                            @if ($enrollment->status == 'pending')
                                <form action="{{ route('admin.enrollment.accept', $enrollment->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    <button class="btn btn-success btn-sm">Accept</button>
                                </form>

                                <form action="{{ route('admin.enrollment.decline', $enrollment->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    <button class="btn btn-danger btn-sm">Decline</button>
                                </form>
                            @else
                                <em class="text-muted">No actions</em>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted">No enrollment requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
