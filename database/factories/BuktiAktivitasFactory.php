<?php

namespace Database\Factories;

use App\Enums\JenisBukti;
use App\Models\BuktiAktivitas;
use App\Models\Pegawai;
use App\Models\TodoList;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BuktiAktivitas>
 */
class BuktiAktivitasFactory extends Factory
{
    public function definition(): array
    {
        $jenis = fake()->randomElement(JenisBukti::cases());

        return [
            'task_id' => TodoList::factory(),
            'pegawai_id' => Pegawai::factory(),
            'jenis_bukti' => $jenis,
            'sumber_bukti' => $jenis === JenisBukti::Link ? fake()->url() : fake()->filePath(),
            'keterangan' => fake()->optional()->sentence(),
        ];
    }
}
