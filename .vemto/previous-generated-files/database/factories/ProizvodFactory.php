<?php

namespace Database\Factories;

use App\Models\Proizvod;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProizvodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Proizvod::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'naziv' => fake()->text(255),
            'cena' => fake()->randomNumber(),
            'na_akciji' => fake()->boolean(),
            'popust_procenat' => fake()->randomNumber(),
        ];
    }
}
