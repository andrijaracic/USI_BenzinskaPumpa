<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            position: relative;
            height: 100vh;
        }

        /* Dugme za user login u gornjem desnom uglu */
        .user-login-btn {
            position: absolute;
            top: 20px;
            right: 30px;
        }

        /* Centrirana forma */
        .login-container {
            max-width: 500px;
            margin: auto;
            padding: 40px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            position: relative;
            top: 50%;
            transform: translateY(-50%);
        }

        .login-title {
            margin-bottom: 30px;
            text-align: center;
            font-weight: 600;
            color: #343a40;
        }

        .btn-login {
            background-color: #0d6efd;
            color: #fff;
        }

        .btn-login:hover {
            background-color: #0b5ed7;
        }

        .btn-user {
            background-color: #6c757d;
            color: #fff;
        }

        .btn-user:hover {
            background-color: #5c636a;
        }
    </style>
</head>
<body>

    <!-- Dugme za user login u gornjem desnom uglu -->
    <div class="user-login-btn">
        <a href="{{ route('login') }}" class="btn btn-user">Login kao Korisnik</a>
    </div>

    <!-- Admin login forma -->
    <div class="login-container">
        <h2 class="login-title">Admin Panel</h2>
        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Šifra</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Šifra" required>
            </div>
            <button type="submit" class="btn btn-login w-100">Login</button>
        </form>

        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
