<?php

namespace Database\Factories;

use App\Models\Pegawai;
use App\Models\TodoList;
use App\Models\WakatimeActivity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<WakatimeActivity>
 */
class WakatimeActivityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'task_id' => TodoList::factory(),
            'pegawai_id' => Pegawai::factory(),
            'activity_date' => fake()->dateTimeBetween('-30 days', 'now'),
            'project_name' => fake()->slug(2),
            'language_name' => fake()->randomElement(['PHP', 'JavaScript', 'TypeScript', 'Python', 'SQL']),
            'duration_hours' => fake()->randomFloat(2, 0.5, 8),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
