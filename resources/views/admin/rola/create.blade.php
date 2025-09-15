<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Dodaj novu rolu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1>Dodaj novu rolu</h1>

    <form action="{{ route('admin.rola.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Naziv role</label>
            <input type="text" name="naziv_role" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Sačuvaj</button>
        <a href="{{ route('admin.rola.index') }}" class="btn btn-secondary">Nazad</a>
    </form>
</div>
</body>
</html>
