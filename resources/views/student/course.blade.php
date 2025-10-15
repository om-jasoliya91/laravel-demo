@extends('layouts.student')
@section('title', 'Courses')
@section('content')

<div class="container my-5">
    <h2 class="mb-4">Available Courses</h2>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        @forelse($courses as $course)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $course->name }}</h5>
                        <p class="card-text">{{ Str::limit($course->description, 100) }}</p>
                        <p><strong>Code:</strong> {{ $course->code }}</p>
                        <p><strong>Duration:</strong> {{ $course->duration }}</p>
                        <p><strong>Price:</strong> ₹{{ $course->price }}</p>
                        <p>
                            <span class="badge {{ $course->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst($course->status) }}
                            </span>
                        </p>

                        @if ($course->status == 'active')
                            <form method="POST" action="{{ route('student.enroll', $course->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-primary mt-auto">Enroll</button>
                            </form>
                        @else
                            <button class="btn btn-secondary mt-auto" disabled>Cannot Enroll</button>
                        @endif

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center text-muted">No courses available.</p>
            </div>
        @endforelse
    </div>
</div>

@endsection
