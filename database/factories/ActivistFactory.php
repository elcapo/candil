<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activist>
 */
class ActivistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'identity_type' => 'nif',
            'identity_number' => fake('es_ES')->dni(),
            'first_name' => fake()->firstName(),
            'surname' => fake()->lastName(),
            'second_surname' => fake()->lastName(),
            'birth_date' => fake()->dateTimeBetween(endDate: '-18 years'),
            'join_date' => fake()->dateTimeBetween(startDate: '-2 years'),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber(),
            'street' => fake()->streetAddress(),
            'city' => fake()->city(),
            'province' => fake()->state(),
            'zip_code' => fake()->postcode(),
        ];
    }

    /**
     * Indicate that the activist has a NIE.
     */
    public function nie(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'identity_type' => 'nie',
                'identity_number' => fake()->nie(),
            ];
        });
    }
}
