<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Admin Panel</a>
        <div class="d-flex">
            <span class="navbar-text text-white me-3">
                Hello, {{ session('user_name') ?? 'Admin' }}
            </span>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-danger">Logout</button>
            </form>

        </div>
    </div>
</nav>
