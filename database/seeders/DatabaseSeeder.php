<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Group;
use App\Models\Activist;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Group::factory(10)
            ->withParent()
            ->create();

        foreach (range(1, 10) as $foo) {
            Activist::factory(5)
                ->withInactiveCollaborations()
                ->withActiveCollaborations()
                ->create();
        }
    }
}
