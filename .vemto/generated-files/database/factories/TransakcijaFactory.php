<?php

namespace Database\Factories;

use App\Models\Transakcija;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransakcijaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transakcija::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'datum' => fake()->dateTime(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
