@extends('layouts.student')

@section('title', 'EditProfile')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Update Profile</h4>
                    </div>
                    <div class="card-body">

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('student.editProfile', $user->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $user->name) }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="age" class="form-label">Age:</label>
                                <input type="number" name="age" class="form-control"
                                    value="{{ old('age', $user->age) }}">
                                @error('age')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="city" class="form-label">City:</label>
                                <input type="text" name="city" class="form-control"
                                    value="{{ old('city', $user->city) }}">
                                @error('city')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address:</label>
                                <textarea name="address" class="form-control" rows="3">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 text-center">
                                <label class="form-label d-block">Current Profile Picture:</label>
                                <img src="{{ $user->profile_pic ? asset('storage/' . $user->profile_pic) : 'https://via.placeholder.com/150' }}"
                                    alt="Profile Picture" class="rounded-circle mb-2" width="100" height="100">
                            </div>

                            <div class="mb-3">
                                <label for="profile_pic" class="form-label">Upload New Profile Picture:</label>
                                <input type="file" name="profile_pic" class="form-control">
                                @error('profile_pic')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Update</button>

                            <div class="mt-3 text-center">
                                <a href="{{ route('student.profile') }}">Back Your profile</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
@endsection
