<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\StavkaTransakcija;
use Illuminate\Database\Eloquent\Factories\Factory;

class StavkaTransakcijaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StavkaTransakcija::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kolicina' => fake()->randomNumber(),
            'transakcija_id' => \App\Models\Transakcija::factory(),
            'proizvod_id' => \App\Models\Proizvod::factory(),
        ];
    }
}
