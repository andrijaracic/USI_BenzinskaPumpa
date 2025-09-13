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
        Rola::firstOrCreate(['naziv_role' => 'admin']);
        Rola::firstOrCreate(['naziv_role' => 'user']);
    }
}
