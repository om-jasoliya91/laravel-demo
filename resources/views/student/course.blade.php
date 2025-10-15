@extends('layouts.student')
@section('title', 'Courses')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <div class="container my-5">
        <h2 class="mb-4">Available Courses</h2>
        <div class="row">
            @forelse($courses as $course)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $course->name }}</h5>
                            <p class="card-text">{{ Str::limit($course->description, 100) }}</p>
                            <p class="mb-1"><strong>Code:</strong> {{ $course->code }}</p>
                            <p class="mb-1"><strong>Duration:</strong> {{ $course->duration }}</p>
                            <p class="mb-1"><strong>Price:</strong> ₹{{ $course->price }}</p>
                            <p>
                                <span class="badge {{ $course->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($course->status) }}
                                </span>
                            </p>
                            <a href="#" class="btn btn-primary mt-auto">Enroll Now</a>
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
    <style>

    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
@endsection
