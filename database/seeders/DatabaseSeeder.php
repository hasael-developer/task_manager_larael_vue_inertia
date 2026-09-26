<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Project::factory(3)
            ->has(Task::factory(5))
            ->create();
    }
}
