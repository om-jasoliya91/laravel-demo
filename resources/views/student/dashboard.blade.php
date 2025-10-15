@extends('layouts.student')

@section('title', 'Dashboard')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

<!-- Hero Section with overlay -->
<section class="position-relative text-white d-flex align-items-center text-center"
    style="background: url('{{ asset('assets/image/book.jpeg') }}') no-repeat center center; background-size: cover; min-height: 80vh;">
    
    <!-- Overlay -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(0, 0, 0, 0.5);"></div>

    <!-- Content -->
    <div class="container position-relative">
        <h1 class="display-4 fw-bold">Browse Our Courses</h1>
        <p class="lead mb-4">Find the perfect course to advance your skills and career</p>
        <a href="{{ route('student.course') }}" class="btn btn-light btn-lg">Explore Courses</a>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
</script>
@endsection
