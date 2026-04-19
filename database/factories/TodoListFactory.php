<?php

namespace Database\Factories;

use App\Enums\PrioritasTask;
use App\Enums\StatusTask;
use App\Models\Kegiatan;
use App\Models\Pegawai;
use App\Models\TodoList;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TodoList>
 */
class TodoListFactory extends Factory
{
    public function definition(): array
    {
        return [
            'kegiatan_id' => Kegiatan::factory(),
            'assigned_to' => Pegawai::factory(),
            'created_by' => User::factory(),
            'nama_task' => fake()->words(5, true),
            'deskripsi_task' => fake()->paragraph(),
            'status' => fake()->randomElement(StatusTask::cases()),
            'prioritas' => fake()->randomElement(PrioritasTask::cases()),
            'progress_persen' => fake()->numberBetween(0, 100),
            'due_date' => fake()->dateTimeBetween('now', '+30 days'),
            'catatan_monev' => null,
        ];
    }

    public function overdue(): static
    {
        return $this->state(fn () => [
            'status' => StatusTask::OnProgress,
            'due_date' => fake()->dateTimeBetween('-30 days', '-1 day'),
        ]);
    }

    public function done(): static
    {
        return $this->state(fn () => [
            'status' => StatusTask::Done,
            'progress_persen' => 100,
        ]);
    }
}
