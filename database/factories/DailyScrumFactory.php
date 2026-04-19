<?php

namespace Database\Factories;

use App\Models\DailyScrum;
use App\Models\Pegawai;
use App\Models\TodoList;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DailyScrum>
 */
class DailyScrumFactory extends Factory
{
    public function definition(): array
    {
        return [
            'pegawai_id' => Pegawai::factory(),
            'task_id' => TodoList::factory(),
            'tanggal' => fake()->dateTimeBetween('-30 days', 'now'),
            'rencana_kerja_harian' => fake()->paragraph(),
            'indikator_capaian' => fake()->sentence(),
            'potensi_risiko' => fake()->optional()->sentence(),
            'realisasi' => fake()->optional()->paragraph(),
            'rencana_tindak_lanjut' => fake()->optional()->sentence(),
        ];
    }
}
