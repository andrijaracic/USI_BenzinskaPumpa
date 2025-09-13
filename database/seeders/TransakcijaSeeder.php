<?php

namespace Database\Seeders;

use App\Models\Transakcija;
use Illuminate\Database\Seeder;

class TransakcijaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Transakcija::factory()
            ->count(5)
            ->create();
    }
}
