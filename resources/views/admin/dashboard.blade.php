<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .dashboard-container {
            max-width: 900px;
            margin: 50px auto;
        }
        .dashboard-header {
            text-align: center;
            margin-bottom: 40px;
        }
        .card {
            cursor: pointer;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h2>Dobrodošao, {{ Auth::user()->name }}</h2>
            <p>Izaberi sekciju za upravljanje</p>
        </div>

        <div class="row g-4">
            <!-- Dugme ka korisnicima -->
            <div class="col-md-4">
                <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                    <div class="card text-center p-4 shadow-sm">
                        <h4>Korisnici</h4>
                        <p>Upravljanje korisnicima</p>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="{{ route('admin.proizvodi.index') }}" class="text-decoration-none">
                    <div class="card text-center p-4 shadow-sm">
                        <h4>Proizvodi</h4>
                        <p>Upravljanje proizvodima</p>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="{{ route('admin.transakcije.index') }}" class="text-decoration-none">
                    <div class="card text-center p-4 shadow-sm">
                        <h4>Transakcije</h4>
                        <p>Upravljanje transakcijama</p>
                    </div>
                </a>
            </div>

        </div>

        <div class="mt-4 text-center">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

