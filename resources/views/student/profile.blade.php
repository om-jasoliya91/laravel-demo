@extends('layouts.student')

@section('title', 'Dashboard')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">


    <div class="container my-5">
        <div class="row justify-content-center">
            @if ($users->id)
                <div class="col-md-6 mb-4">
                    <div class="profile-card text-center">
                        <!-- Profile Image -->
                        <img src="{{ asset('storage/' . $users->profile_pic) }}" alt="Profile" width="150"
                            height="150" class="rounded-circle">

                        <h3>{{ $users->name }}</h3>

                        <div class="profile-info mt-3 text-start">
                            <p><i class="bi bi-envelope-fill"></i> Email: {{ $users->email }}</p>
                            <p><i class="bi bi-person-fill"></i> Age: {{ $users->age }}</p>
                            <p><i class="bi bi-geo-alt-fill"></i> City: {{ $users->city }}</p>
                            <p><i class="bi bi-house-fill"></i> Address: {{ $users->address }}</p>
                        </div>


                        <div class="mt-4">
                            <a href="{{ route('student.editProfile', $users->id) }}" class="btn btn-light btn-sm me-2">Edit
                                Profile</a>
                            <a href="{{ route('student.dashboard') }}" class="btn btn-outline-light btn-sm">Back</a>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-12">
                    <p class="text-center text-muted">No user profile available.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
@endsection
