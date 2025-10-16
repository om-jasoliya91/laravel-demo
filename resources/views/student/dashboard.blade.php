@extends('layouts.student')
@section('title', 'Dashboard')

@section('content')
<section class="position-relative text-dark d-flex align-items-center text-center"
    style="background: url('{{ asset('assets/image/book.jpeg') }}') no-repeat center center; background-size: cover; min-height: 80vh;">
    <div class="container position-relative">
        <h1 class="display-4 fw-bold">Browse Our Courses</h1>
        <p class="lead mb-4 text-white">Find the perfect course to advance your skills and career</p>
        <a href="{{ route('student.course') }}" class="btn btn-light btn-lg">Explore Courses</a>
    </div>
</section>
@endsection
