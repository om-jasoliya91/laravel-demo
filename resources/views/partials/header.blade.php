@php
    // Determine role and name
    if(session()->has('admin_id')) {
        $role = 0;
        $name = session('admin_name');
        $dashboardRoute = route('admin.dashboard');
        $panelName = 'Admin Panel';
    } elseif(session()->has('student_id')) {
        $role = 1;
        $name = session('student_name');
        $dashboardRoute = route('student.dashboard');
        $panelName = 'Student Panel';
    } else {
        $role = null;
        $name = 'Guest';
        $dashboardRoute = url('/');
        $panelName = 'Panel';
    }
    // echo "<pre>";
    // print_r($role);
    // echo "</pre>";
    // exit;
@endphp

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ $dashboardRoute }}">
            {{ $panelName }}
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
            <span class="navbar-text text-white me-3">
                Hello, {{ $name }}
            </span>

            @if($role !== null)
            <form action="{{ route('logout', $role == 0 ? 'admin' : 'student') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
            </form>
            @endif
        </div>
    </div>
</nav>
