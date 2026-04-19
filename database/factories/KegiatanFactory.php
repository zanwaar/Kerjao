<?php

namespace Database\Factories;

use App\Enums\StatusKegiatan;
use App\Models\Kegiatan;
use App\Models\ProgramKerja;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Kegiatan>
 */
class KegiatanFactory extends Factory
{
    public function definition(): array
    {
        $mulai = fake()->dateTimeBetween('-3 months', 'now');
        $selesai = fake()->dateTimeBetween($mulai, '+3 months');

        return [
            'program_kerja_id' => ProgramKerja::factory(),
            'created_by' => User::factory(),
            'nama_kegiatan' => 'Kegiatan ' . fake()->words(3, true),
            'deskripsi' => fake()->paragraph(),
            'target_capaian' => fake()->sentence(),
            'waktu_mulai' => $mulai,
            'waktu_selesai' => $selesai,
            'status_kegiatan' => fake()->randomElement(StatusKegiatan::cases()),
        ];
    }

    public function active(): static
    {
        return $this->state(fn () => ['status_kegiatan' => StatusKegiatan::Active]);
    }
}
