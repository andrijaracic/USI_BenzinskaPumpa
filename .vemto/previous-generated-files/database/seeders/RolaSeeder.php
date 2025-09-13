<?php

namespace Database\Seeders;

use App\Models\Rola;
use Illuminate\Database\Seeder;

class RolaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rola::factory()
            ->count(5)
            ->create();
    }
}
