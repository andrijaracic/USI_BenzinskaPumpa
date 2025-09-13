<x-app-layout>
    <h2 class="text-center text-2xl font-bold mb-6" style="margin: 20px">Moje transakcije</h2>

    @php
        $transakcije = \App\Models\Transakcija::where('user_id', auth()->id())
            ->with('stavkaTransakcijas.proizvod')
            ->get();
    @endphp

    <div class="overflow-x-auto w-full">
        <table id="transakcijeTable" class="min-w-full divide-y divide-gray-200 border w-full text-center">
            <thead class="bg-gray-50 cursor-pointer">
                <tr>
                    <th onclick="sortTable(0)" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Datum</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Ukupna cena (RSD)</th>
                    <th onclick="sortTable(2)" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Ostvareni bodovi</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Detalji</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transakcije as $t)
                    @php
                        $ukupnaCena = $t->stavkaTransakcijas->sum(fn($s) => $s->kolicina * $s->proizvod->cena);
                        $bodovi = floor($ukupnaCena / 1000) * 20;
                    @endphp
                    <tr class="hover:bg-gray-100 cursor-pointer" onclick="toggleDetails({{ $t->id }})">
                        <td class="px-6 py-4 whitespace-nowrap" data-timestamp="{{ $t->created_at->timestamp }}">{{ $t->created_at->format('d.m.Y H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($ukupnaCena, 2, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap" data-bodovi="{{ $bodovi }}">{{ $bodovi }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600" style="color: darkgreen">Prikaži</button>
                        </td>
                    </tr>
                    <!-- Detalji transakcije -->
                    <tr id="details-{{ $t->id }}" class="bg-gray-50 hidden">
                        <td colspan="4" class="px-6 py-4 text-left">
                            <table class="w-full text-center border">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-2">Proizvod</th>
                                        <th class="px-4 py-2">Količina</th>
                                        <th class="px-4 py-2">Cena po jedinici</th>
                                        <th class="px-4 py-2">Bodovi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($t->stavkaTransakcijas as $s)
                                        @php
                                            $stavkaBodovi = floor(($s->kolicina * $s->proizvod->cena) / 1000) * 20;
                                        @endphp
                                        <tr>
                                            <td class="px-4 py-2">{{ $s->proizvod->naziv }}</td>
                                            <td class="px-4 py-2">{{ $s->kolicina }}</td>
                                            <td class="px-4 py-2">{{ number_format($s->proizvod->cena, 2, ',', '.') }}</td>
                                            <td class="px-4 py-2">{{ $stavkaBodovi }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        let sortDirections = [true, true]; // true = ascending, false = descending

        function sortTable(columnIndex) {
            const table = document.getElementById("transakcijeTable");
            const tbody = table.tBodies[0];
            const rows = Array.from(tbody.rows).filter(r => !r.id.startsWith('details-'));

            const ascending = sortDirections[columnIndex];
            rows.sort((a, b) => {
                let aValue, bValue;

                if(columnIndex === 0) { // Datum
                    aValue = parseInt(a.cells[columnIndex].dataset.timestamp);
                    bValue = parseInt(b.cells[columnIndex].dataset.timestamp);
                } else if(columnIndex === 2) { // Bodovi
                    aValue = parseInt(a.cells[columnIndex].dataset.bodovi);
                    bValue = parseInt(b.cells[columnIndex].dataset.bodovi);
                }

                return ascending ? aValue - bValue : bValue - aValue;
            });

            rows.forEach(row => {
                tbody.appendChild(row);
                // Prikaži ili sakrij povezane detalje odmah ispod
                const detailsRow = document.getElementById('details-' + row.getAttribute('onclick').match(/\d+/)[0]);
                tbody.appendChild(detailsRow);
            });

            sortDirections[columnIndex] = !ascending;
        }

        function toggleDetails(id) {
            const row = document.getElementById('details-' + id);
            row.classList.toggle('hidden');
        }
    </script>
</x-app-layout>
