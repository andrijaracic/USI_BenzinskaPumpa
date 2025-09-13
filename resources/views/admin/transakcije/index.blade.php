{{-- resources/views/transakcije/index.blade.php --}}
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Lista transakcija</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2 class="mb-3">Lista transakcija</h2>

    <a href="{{ route('admin.dashboard') }}" class="btn btn-danger mb-3">Nazad na Dashboard</a>

    <a href="{{ route('admin.transakcije.create') }}" class="btn btn-primary mb-3">
        + Nova transakcija
    </a>

    @if($transakcije->isEmpty())
        <div class="alert alert-info">
            Trenutno nema unetih transakcija.
        </div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Datum</th>
                    <th>Korisnik</th>
                    <th>Ukupna cena</th>
                    <th>Bodovi</th>
                    <th>Detalji</th>
                    <th>Akcije</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transakcije as $t)
                    @php
                        // Ukupna cena transakcije
                        $ukupnaCena = $t->stavkaTransakcijas->sum(function($stavka) {
                            return $stavka->kolicina * $stavka->proizvod->cena;
                        });

                        // Bodovi: 20 bodova na svakih 1000 RSD
                        $ukupnoBodova = floor($ukupnaCena / 1000) * 20;
                    @endphp
                    <tr>
                        <td>{{ $t->id }}</td>
                        <td>{{ \Carbon\Carbon::parse($t->datum)->format('d.m.Y') }}</td>
                        <td>{{ $t->user->name }}</td>
                        <td>{{ number_format($ukupnaCena, 2) }} RSD</td>
                        <td>{{ $ukupnoBodova }}</td>
                        <td>
                            <a href="{{ route('admin.transakcije.edit', $t) }}" class="btn btn-sm btn-info">
                                Edit
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('admin.transakcije.destroy', $t) }}" method="POST" onsubmit="return confirm('Da li ste sigurni da želite obrisati ovu transakciju?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    Obriši
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
</body>
</html>


