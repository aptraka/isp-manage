<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login - ISP Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <div class="login-wrapper">
        <div class="login-card">

            <div class="text-center mb-4">
                <div class="login-logo">
                    <i class="bi bi-wifi"></i>
                </div>

                <h4 class="fw-bold">ISP Management</h4>
                <p class="text-muted small">
                    Silakan login untuk mengakses sistem
                </p>
            </div>

            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
            @endif

            <form action="{{ route('login.process') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email</label>

                    <input type="email"
                        name="email"
                        class="form-control"
                        placeholder="Masukkan email"
                        value="{{ old('email') }}"
                        required
                        autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>

                    <input type="password"
                        name="password"
                        class="form-control"
                        placeholder="Masukkan password"
                        required>
                </div>

                <div class="form-check mb-4">
                    <input type="checkbox"
                        name="remember"
                        value="1"
                        class="form-check-input"
                        id="remember">

                    <label for="remember" class="form-check-label">
                        Ingat saya
                    </label>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2">
                    <i class="bi bi-box-arrow-in-right me-2"></i>
                    Login
                </button>
            </form>

            <div class="text-center mt-4">
                <small class="text-muted">
                    ISP Customer Management System
                </small>
            </div>

        </div>

    </div>

</body>

</html>