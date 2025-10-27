@extends('layouts.main')

@section('title', 'Students List')

@section('content')
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Students List</h4>
                <a href="{{ route('admin.addCourse') }}" class="btn btn-light btn-sm">Add New Course</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Description</th>
                                <th>Duration</th>
                                <th>Price</th>
                                <th>status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse ($courses as $course)
                                <tr>
                                    <td>{{ $course->id }}</td>

                                    <td>{{ $course->name }}</td>
                                    <td>{{ $course->code }}</td>
                                    <td>{{ $course->description }}</td>
                                    <td>{{ $course->duration }}</td>
                                    <td>{{ $course->price }}</td>
                                    <td>
                                        <span class="badge {{ $course->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($course->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.editCourse', $course->id) }}"
                                            class="btn btn-sm btn-primary">Edit</a>
                                        {{-- <a href="{{ route('admin.editCourse', $course->id) }}"
                                            class="btn btn-sm btn-primary">
                                            Edit
                                        </a> --}}


                                        <form action="{{ route('admin.courseDelete', $course->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">No students found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- Pagination links -->

                </div>
            </div>
        </div>
        <div class="mt-4">
            {{ $courses->links() }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
@endsection
