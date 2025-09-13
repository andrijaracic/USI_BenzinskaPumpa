<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proizvodi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
    <h1 class="mb-4">Proizvodi</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.dashboard') }}" class="btn btn-danger mb-3">Nazad na Dashboard</a>


    <a href="{{ route('admin.proizvodi.create') }}" class="btn btn-primary mb-3">Dodaj novi proizvod</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Naziv</th>
                <th>Cena</th>
                <th>Na akciji</th>
                <th>Popust %</th>
                <th>Akcije</th>
            </tr>
        </thead>
        <tbody>
            @forelse($proizvodi as $proizvod)
            <tr>
                <td>{{ $proizvod->id }}</td>
                <td>{{ $proizvod->naziv }}</td>
                <td>{{ $proizvod->cena }}</td>
                <td>{{ $proizvod->na_akciji ? 'Da' : 'Ne' }}</td>
                <td>{{ $proizvod->popust_procenat ?? '-' }}</td>
                <td>
                    <a href="{{ route('admin.proizvodi.edit', $proizvod) }}" class="btn btn-sm btn-warning">Izmeni</a>
                    <form action="{{ route('admin.proizvodi.destroy', $proizvod) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('Da li ste sigurni da želite da obrišete proizvod?')">
                            Obriši
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Nema proizvoda u bazi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
