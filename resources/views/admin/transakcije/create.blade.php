{{-- resources/views/transakcije/create.blade.php --}}
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Kreiraj transakciju</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // Lista proizvoda iz backend-a
        let proizvodi = @json($proizvodi); // $proizvodi = Proizvod::all() u controlleru

        function addStavka() {
            const container = document.getElementById('stavke-container');
            const index = container.children.length;

            const div = document.createElement('div');
            div.classList.add('row', 'mb-2');

            div.innerHTML = `
                <div class="col-md-5">
                    <select name="stavke[${index}][proizvod_id]" class="form-select" required onchange="updateUkupno()">
                        <option value="">-- Izaberi proizvod --</option>
                        ${proizvodi.map(p => `<option value="${p.id}" data-cena="${p.cena}">${p.naziv} (${p.cena} RSD)</option>`).join('')}
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="stavke[${index}][kolicina]" class="form-control" min="1" value="1" required oninput="updateUkupno()">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger" onclick="this.closest('.row').remove(); updateUkupno()">X</button>
                </div>
            `;

            container.appendChild(div);
            updateUkupno();
        }

        function updateUkupno() {
            let container = document.getElementById('stavke-container');
            let ukupno = 0;

            Array.from(container.children).forEach(row => {
                let select = row.querySelector('select');
                let kolicina = row.querySelector('input[type=number]').value;

                let cena = 0;
                if(select.value) {
                    cena = Number(select.options[select.selectedIndex].dataset.cena);
                }
                ukupno += cena * kolicina;
            });

            document.getElementById('ukupnaCena').innerText = ukupno.toLocaleString('sr-RS', {minimumFractionDigits: 2, maximumFractionDigits:2}) + ' RSD';

            // Bodovi: 50 bodova na svakih 1000 RSD
            let bodovi = Math.floor(ukupno / 1000) * 50;
            document.getElementById('bodovi').innerText = bodovi;
        }
    </script>
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2>Kreiraj transakciju</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.transakcije.store') }}">
        @csrf

        <div class="mb-3">
            <label for="user_id" class="form-label">Korisnik</label>
            <select name="user_id" id="user_id" class="form-select" required>
                <option value="">-- Izaberi korisnika --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="datum" class="form-label">Datum</label>
            <input type="date" name="datum" id="datum" class="form-control" required>
        </div>

        <h5>Stavke transakcije</h5>
        <div id="stavke-container"></div>

        <button type="button" class="btn btn-secondary mb-3" onclick="addStavka()">+ Dodaj stavku</button>
        <br>

        <h5>Ukupna cena: <span id="ukupnaCena">0 RSD</span></h5>
        <h5>Ostvareni bodovi: <span id="bodovi">0</span></h5>

        <button type="submit" class="btn btn-success">Sačuvaj</button>
        <a href="{{ route('admin.transakcije.index') }}" class="btn btn-outline-secondary">Nazad</a>
    </form>
</div>
</body>
</html>
