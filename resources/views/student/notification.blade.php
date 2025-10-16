@extends('layouts.student')
@section('title', 'Notifications')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <div class="container my-5">
        <h2 class="mb-4 text-center">Notifications</h2>

        @if ($notifications && $notifications->count() > 0)
            @foreach ($notifications as $note)
                @php
                    $status = $note->data['status'] ?? 'info';
                    $alertClass = $status === 'accept' ? 'success' : ($status === 'decline' ? 'danger' : 'info');
                @endphp

                <div class="alert alert-{{ $alertClass }} fade show" role="alert">
                    <div>
                        {{ $note->data['message'] ?? 'No message' }}
                    </div>
                    <div class="mt-1">
                        <small class="text-muted">{{ $note->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-center text-muted">No new notifications.</p>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
@endsection
