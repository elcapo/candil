<?php

namespace Database\Factories;

use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
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
            'join_date' => fake()->dateTimeBetween(startDate: '-5 years'),
            'email' => fake()->email(),
            'phone' => fake()->regexify('[6-9]{1}[0-9]{8}'),
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

    /**
     * Indicate that the activist has active collaborations.
     */
    public function withActiveCollaborations(): Factory
    {
        return $this->hasAttached(Group::all()->random(), [
            'join_date' => fake()->dateTimeBetween(startDate: '-5 years'),
            'status' => fake()->randomElement([
                'in_practice',
                'active',
            ]),
        ]);
    }

        /**
     * Indicate that the activist has inactive collaborations.
     */
    public function withInactiveCollaborations(): Factory
    {
        return $this->hasAttached(Group::all()->random(), [
            'join_date' => fake()->dateTimeBetween(startDate: '-5 years', endDate: '-1 year'),
            'leave_date' => fake()->dateTimeBetween(startDate: '-1 years'),
            'status' => 'inactive',
        ]);
    }
}
