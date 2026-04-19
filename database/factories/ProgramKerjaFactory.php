<?php

namespace Database\Factories;

use App\Enums\StatusProgram;
use App\Models\ProgramKerja;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProgramKerja>
 */
class ProgramKerjaFactory extends Factory
{
    public function definition(): array
    {
        $mulai = fake()->dateTimeBetween('-6 months', 'now');
        $selesai = fake()->dateTimeBetween($mulai, '+6 months');

        return [
            'created_by' => User::factory(),
            'nama_program' => 'Program ' . fake()->words(3, true),
            'deskripsi' => fake()->paragraph(),
            'waktu_mulai' => $mulai,
            'waktu_selesai' => $selesai,
            'status_program' => fake()->randomElement(StatusProgram::cases()),
        ];
    }

    public function active(): static
    {
        return $this->state(fn () => ['status_program' => StatusProgram::Active]);
    }
}
