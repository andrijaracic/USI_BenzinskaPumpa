<?php

namespace Database\Seeders;

use App\Models\Proizvod;
use Illuminate\Database\Seeder;

class ProizvodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $goriva = [
            ['naziv' => 'BMB 95', 'cena' => 181],
            ['naziv' => 'BMB 100', 'cena' => 201],
            ['naziv' => 'Evrodizel', 'cena' => 194],
            ['naziv' => 'Evrodizel Premium', 'cena' => 201],
            ['naziv' => 'TNG 95', 'cena' => 95],
        ];

        foreach ($goriva as $gorivo) {
            Proizvod::firstOrCreate(
                ['naziv' => $gorivo['naziv']], // uslov (pretraga po nazivu)
                [
                    'cena' => $gorivo['cena'],
                    'na_akciji' => false,
                    'popust_procenat' => null,
                ]
            );
        }
    }
}
