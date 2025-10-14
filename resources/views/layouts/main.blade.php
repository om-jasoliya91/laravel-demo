<!DOCTYPE html>
<html lang="en">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { display: flex; min-height: 100vh; flex-direction: column; }
        .admin-wrapper { display: flex; flex: 1; }
        .sidebar { width: 200px; background-color: #343a40; color: #fff; min-height: 100vh; }
        .sidebar a { color: #fff; display: block; padding: 10px; text-decoration: none; }
        .sidebar a:hover { background-color: #495057; }
        .content { flex: 1; padding: 20px; }
    </style>
</head>
<body>
    @include('partials.header')

    <div class="admin-wrapper">
        <div class="sidebar">
            @include('partials.sidebar')
        </div>

        <div class="content">
            @yield('content')
        </div>
    </div>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
