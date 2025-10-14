@extends('layouts.main')

@section('title', 'Edit Student')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Edit Student</h4>
                </div>
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('admin.studentEdit', $students->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $students->name) }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $students->email) }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Age --}}
                        <div class="mb-3">
                            <label for="age" class="form-label">Age:</label>
                            <input type="number" name="age" class="form-control" value="{{ old('age', $students->age) }}">
                            @error('age')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- City --}}
                        <div class="mb-3">
                            <label for="city" class="form-label">City:</label>
                            <input type="text" name="city" class="form-control" value="{{ old('city', $students->city) }}">
                            @error('city')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Address --}}
                        <div class="mb-3">
                            <label for="address" class="form-label">Address:</label>
                            <textarea name="address" class="form-control" rows="3">{{ old('address', $students->address) }}</textarea>
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Profile Picture --}}
                        <div class="mb-3">
                            <label for="profile_pic" class="form-label">Profile Picture:</label>
                            @if ($students->profile_pic)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $students->profile_pic) }}" alt="Profile" width="50" height="50" class="rounded-circle">
                                </div>
                            @endif
                            <input type="file" name="profile_pic" class="form-control">
                            @error('profile_pic')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Update Student</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
