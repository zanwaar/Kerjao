<?php

namespace Database\Factories;

use App\Enums\StatusPegawai;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pegawai>
 */
class PegawaiFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => null,
            'nama_pegawai' => fake()->name(),
            'nip' => fake()->unique()->numerify('##################'),
            'jabatan' => fake()->randomElement(['Staff', 'Analis', 'Programmer', 'Kepala Seksi', 'Kepala Bidang']),
            'unit_kerja' => fake()->randomElement(['Bidang TI', 'Bidang Perencanaan', 'Bidang Keuangan', 'Sekretariat']),
            'status_pegawai' => StatusPegawai::Aktif,
            'github_username' => null,
            'wakatime_user_key' => null,
        ];
    }

    public function withUser(): static
    {
        return $this->state(fn () => [
            'user_id' => User::factory(),
        ]);
    }

    public function nonaktif(): static
    {
        return $this->state(fn () => [
            'status_pegawai' => StatusPegawai::Nonaktif,
        ]);
    }
}
