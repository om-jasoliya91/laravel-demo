<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        @php
            $role = session('user_role');
            $name = session('user_name') ?? 'Guest';
            $dashboardRoute = $role == 0 ? route('admin.dashboard') : route('student.dashboard');
            $panelName = $role == 0 ? 'Admin Panel' : 'Student Panel';
        @endphp

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

            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
            </form>
        </div>
    </div>
</nav>
