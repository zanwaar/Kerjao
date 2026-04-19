<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@kerjao.test'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
            ]
        );
        $adminUser->assignRole('admin');

        Pegawai::firstOrCreate(
            ['user_id' => $adminUser->id],
            [
                'nama_pegawai' => 'Administrator',
                'jabatan' => 'Administrator Sistem',
                'unit_kerja' => 'Bidang TI',
            ]
        );

        $pimpinanUser = User::firstOrCreate(
            ['email' => 'pimpinan@kerjao.test'],
            [
                'name' => 'Kepala Bidang',
                'password' => Hash::make('password'),
            ]
        );
        $pimpinanUser->assignRole('pimpinan');

        Pegawai::firstOrCreate(
            ['user_id' => $pimpinanUser->id],
            [
                'nama_pegawai' => 'Kepala Bidang',
                'jabatan' => 'Kepala Bidang',
                'unit_kerja' => 'Bidang TI',
            ]
        );

        $pegawaiUsers = [
            ['email' => 'pegawai1@kerjao.test', 'name' => 'Budi Santoso', 'jabatan' => 'Programmer', 'nip' => '199001012020011001'],
            ['email' => 'pegawai2@kerjao.test', 'name' => 'Siti Rahayu', 'jabatan' => 'Analis', 'nip' => '199205152020012002'],
            ['email' => 'pegawai3@kerjao.test', 'name' => 'Agus Setiawan', 'jabatan' => 'Staff', 'nip' => '199308202021011003'],
        ];

        foreach ($pegawaiUsers as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                ['name' => $data['name'], 'password' => Hash::make('password')]
            );
            $user->assignRole('pegawai');

            Pegawai::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'nama_pegawai' => $data['name'],
                    'nip' => $data['nip'],
                    'jabatan' => $data['jabatan'],
                    'unit_kerja' => 'Bidang TI',
                ]
            );
        }
    }
}
