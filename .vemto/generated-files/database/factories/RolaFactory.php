<?php

namespace Database\Factories;

use App\Models\Rola;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class RolaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rola::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'naziv_role' => fake()->text(255),
        ];
    }
}
