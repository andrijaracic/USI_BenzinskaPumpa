<x-app-layout>
    <h2 class="text-center text-2xl font-bold mb-6" style="margin: 10px">Svi proizvodi</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 px-6 mb-12">
        @foreach($proizvodi as $proizvod)
            <div class="bg-white shadow-lg rounded-xl p-4 flex flex-col items-center justify-center text-center hover:scale-105 transition-transform duration-200" style="height: 130px">
                <h5 class="font-semibold text-lg mb-2">{{ $proizvod->naziv }}</h5>

                @if($proizvod->popust_procenat > 0)
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
                @else
                    <p class="text-gray-800 font-bold text-xl">
                        {{ number_format($proizvod->cena, 2, ',', '.') }} RSD
                    </p>
                @endif
            </div>
        @endforeach
    </div>
</x-app-layout>
