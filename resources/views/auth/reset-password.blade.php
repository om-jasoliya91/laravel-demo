<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5" style="max-width: 500px;">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white text-center">
                <h4>Reset Password</h4>
            </div>
            <div class="card-body">

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <label>Email Address:</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', request('email')) }}" required>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label>New Password:</label>
                        <input type="password" name="password" class="form-control" required>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label>Confirm Password:</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Reset Password</button>

                    <div class="mt-3 text-center">
                        <a href="{{ route('login.view') }}">Back to Login</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>
</html>
