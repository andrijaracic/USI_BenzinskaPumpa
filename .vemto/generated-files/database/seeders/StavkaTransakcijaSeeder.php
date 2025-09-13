<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StavkaTransakcija;

class StavkaTransakcijaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StavkaTransakcija::factory()
            ->count(5)
            ->create();
    }
}
