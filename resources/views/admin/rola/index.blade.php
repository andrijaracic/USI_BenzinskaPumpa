<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Rolle - Lista</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1>Role</h1>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-danger mb-3">Nazad na dashboard</a>

    <a href="{{ route('admin.rola.create') }}" class="btn btn-primary mb-3">Dodaj novu rolu</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Naziv</th>
                <th>Akcije</th>
            </tr>
        </thead>
        <tbody>
            @foreach($role as $rola)
                <tr>
                    <td>{{ $rola->id }}</td>
                    <td>{{ $rola->naziv_role }}</td>
                    <td>
                        <a href="{{ route('admin.rola.edit', $rola) }}" class="btn btn-warning btn-sm">Izmeni</a>
                        <form action="{{ route('admin.rola.destroy', $rola) }}" method="POST" style="display:inline-block;">
                            @csrf 
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Obriši</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
