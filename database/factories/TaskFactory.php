<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Project; 
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'name' => fake()->sentence(5),
            'priority' => fake()->numberBetween(1, 10),
        ];
    }
}
