@extends('layouts.main')
@section('title', 'Add Courses')
@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h2>Add Course</h2>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form method="POST" action="{{ route('admin.editCourse', $courses->id) }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Update Course:</label>
                                <input type="text" class="form-control" name="name"
                                    value="{{ old('name', $courses->name) }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Course Code:</label>
                                <input type="text" class="form-control" name="code"
                                    value="{{ old('code', $courses->code) }}">
                                @error('code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description:</label>
                                <textarea name="description" class="form-control" rows="4">{{ old('description', $courses->description) }}</textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Duration:</label>
                                <input type="text" class="form-control" name="duration"
                                    value="{{ old('duration', $courses->duration) }}">
                                @error('duration')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Price:</label>
                                <input type="number" step="0.01" class="form-control" name="price"
                                    value="{{ old('price', $courses->price) }}">
                                @error('price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status:</label>
                                <select name="status" class="form-select">
                                    <option value="">-- Select Status --</option>
                                    <option value="active" {{ old('status',$courses->status) == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ old('status',$courses->status) == 'inactive' ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
