<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Group;
use App\Models\Person;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Group::factory(10)->withParent()->create();
        Person::factory(50)->withActiveCollaborations();
        Person::factory(20)->withActiveCollaborations()->withInactiveCollaborations();
    }
}
