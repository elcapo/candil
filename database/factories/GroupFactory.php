<?php

namespace Database\Factories;

use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $city = fake()->city();

        return [
            'name' => $city,
            'type' => fake()->randomElement([
                'local_group',
                'action_group',
                'university_group',
                'autonomous_entity_group',
                'state_secretariat_group',
                'country_work_group',
                'autonomous_entity',
                'committee',
                'commission',
                'work_group',
            ]),
            'email' => Str::slug($city).'@domain.org',
            'phone' => fake()->regexify('[6-9]{1}[0-9]{8}'),
            'street' => fake()->streetAddress(),
            'city' => $city,
            'province' => fake()->state(),
            'zip_code' => fake()->postcode(),
        ];
    }

    /**
     * Indicate that the group has a parent group.
     */
    public function withParent(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'part_of_group_id' => Group::factory(state: ['type' => 'autonomous_entity']),
                'type' => fake()->randomElement([
                    'local_group',
                    'action_group',
                    'university_group',
                    'autonomous_entity_group',
                    'state_secretariat_group',
                    'country_work_group',
                    'committee',
                    'commission',
                    'work_group',
                ]),
            ];
        });
    }
}
