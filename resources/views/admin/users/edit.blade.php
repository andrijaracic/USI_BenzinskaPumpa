<!DOCTYPE html>
<html>
<head>
    <title>Izmeni korisnika</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Izmeni korisnika</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Ime</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <div class="mb-3">
            <label>Šifra (ostavi prazno ako ne menjaš)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label>Rola</label>
            <select name="rola_id" class="form-control">
                <option value="1" {{ $user->rola_id == 1 ? 'selected' : '' }}>Admin</option>
                <option value="2" {{ $user->rola_id == 2 ? 'selected' : '' }}>Korisnik</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Sačuvaj promene</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Nazad</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

