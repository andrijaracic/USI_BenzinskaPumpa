<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj proizvod</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
    <h1 class="mb-4">Dodaj proizvod</h1>

    <form action="{{ route('admin.proizvodi.store') }}" method="POST" class="card p-4 shadow-sm rounded">
        @csrf
        <div class="mb-3">
            <label for="naziv" class="form-label">Naziv</label>
            <input type="text" name="naziv" id="naziv" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="cena" class="form-label">Cena</label>
            <input type="number" name="cena" id="cena" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="na_akciji" class="form-label">Na akciji</label>
            <select name="na_akciji" id="na_akciji" class="form-select" required>
                <option value="0">Ne</option>
                <option value="1">Da</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="popust_procenat" class="form-label">Popust (%)</label>
            <input type="number" name="popust_procenat" id="popust_procenat" class="form-control" disabled>
        </div>
        <button type="submit" class="btn btn-success">Sačuvaj</button>
        <a href="{{ route('admin.proizvodi.index') }}" class="btn btn-secondary">Nazad</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const akcijaSelect = document.getElementById('na_akciji');
    const popustInput = document.getElementById('popust_procenat');

    // Funkcija koja uključuje/isključuje polje za popust
    function togglePopust() {
        if (akcijaSelect.value === '1') {
            popustInput.disabled = false;
        } else {
            popustInput.disabled = true;
            popustInput.value = ''; // obriši vrednost ako nije na akciji
        }
    }

    // Pokreni funkciju prilikom promene selekta
    akcijaSelect.addEventListener('change', togglePopust);

    // Po inicijalnom učitavanju stranice
    togglePopust();
</script>
</body>
</html>
