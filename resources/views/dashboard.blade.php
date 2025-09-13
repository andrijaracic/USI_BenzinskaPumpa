@php
    $ukupniBodovi = 0;

    $korisnikTransakcije = $transakcije->where('user_id', auth()->id());

    foreach($korisnikTransakcije as $t) {
        $ukupnaCena = $t->stavkaTransakcijas->sum(function($stavka) {
            return $stavka->kolicina * $stavka->proizvod->cena;
        });

        $ukupniBodovi += floor($ukupnaCena / 1000) * 20;
    }
@endphp

<x-app-layout>
    
    
    <div class="flex justify-between mt-6 px-6">
        <!-- Levi div: Kartica sa cenama goriva -->
        <div class="bg-gradient-to-r from-yellow-300 via-yellow-400 to-yellow-300 
                    shadow-lg rounded-xl p-4 mb-6 border-4 border-yellow-500 
                    w-80" style="width: 500px">
            <h3 class="text-lg font-extrabold mb-3 text-center text-gray-900 uppercase">
                Cene goriva
            </h3>
            <table class="w-full text-sm border-collapse">
                <tbody>
                    @foreach($goriva as $gorivo)
                        <tr class="border-b last:border-0 hover:bg-yellow-200 transition-all duration-150">
                            <td class="py-1 text-left font-bold text-gray-900">
                                {{ $gorivo->naziv }}
                            </td>
                            <td class="py-1 text-right font-semibold text-green-700">
                                {{ number_format($gorivo->cena, 2, ',', '.') }} RSD
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Desni div: Ukupni bodovi -->
        <div class="bg-blue-800 text-white font-bold px-4 py-2 rounded-lg shadow-lg flex items-center justify-center w-40" style="background-color: rgb(19, 19, 86);height:100px">
            Ostvareni bodovi: {{ $ukupniBodovi }}
        </div>
    </div>


    <!-- Treći div: Proizvodi na akciji ispod prethodna dva -->
    <h2 class="text-center text-2xl font-bold mb-6">NA AKCIJI</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 px-6 mb-12">
        @foreach($proizvodiNaAkciji as $proizvod)
            <div class="bg-white shadow-lg rounded-xl p-4 flex flex-col items-center justify-center text-center hover:scale-105 transition-transform duration-200">
                <h5 class="font-semibold text-lg mb-2">{{ $proizvod->naziv }}</h5>

                @php
                    $novaCena = $proizvod->cena - ($proizvod->cena * $proizvod->popust_procenat / 100);
                @endphp

                <p class="text-gray-400" style="text-decoration: line-through">
                    {{ number_format($proizvod->cena, 2, ',', '.') }} RSD
                </p>
                <p class="text-green-600 font-bold text-xl">
                    {{ number_format($novaCena, 2, ',', '.') }} RSD
                </p>
                <p class="text-red-500 font-semibold">-{{ $proizvod->popust_procenat }}%</p>
            </div>
        @endforeach
    </div>
</x-app-layout>
