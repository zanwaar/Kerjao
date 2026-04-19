<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // pegawai
            'pegawai.view', 'pegawai.create', 'pegawai.edit', 'pegawai.delete',
            // program kerja
            'program-kerja.view', 'program-kerja.create', 'program-kerja.edit', 'program-kerja.delete',
            // kegiatan
            'kegiatan.view', 'kegiatan.create', 'kegiatan.edit', 'kegiatan.delete',
            // task
            'task.view', 'task.create', 'task.edit', 'task.delete', 'task.view-all',
            // daily scrum
            'daily-scrum.view', 'daily-scrum.create', 'daily-scrum.edit', 'daily-scrum.view-all',
            // bukti aktivitas
            'bukti-aktivitas.view', 'bukti-aktivitas.create', 'bukti-aktivitas.edit', 'bukti-aktivitas.delete',
            // github & wakatime
            'github-activity.view', 'github-activity.create', 'github-activity.edit',
            'wakatime-activity.view', 'wakatime-activity.create', 'wakatime-activity.edit',
            // laporan
            'laporan.view', 'laporan.export',
            // dashboard
            'dashboard.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(Permission::all());

        $pimpinan = Role::firstOrCreate(['name' => 'pimpinan']);
        $pimpinan->syncPermissions([
            'pegawai.view',
            'program-kerja.view',
            'kegiatan.view',
            'task.view', 'task.view-all',
            'daily-scrum.view', 'daily-scrum.view-all',
            'bukti-aktivitas.view',
            'github-activity.view',
            'wakatime-activity.view',
            'laporan.view', 'laporan.export',
            'dashboard.view',
        ]);

        $pegawai = Role::firstOrCreate(['name' => 'pegawai']);
        $pegawai->syncPermissions([
            'program-kerja.view',
            'kegiatan.view',
            'task.view',
            'daily-scrum.view', 'daily-scrum.create', 'daily-scrum.edit',
            'bukti-aktivitas.view', 'bukti-aktivitas.create', 'bukti-aktivitas.edit', 'bukti-aktivitas.delete',
            'github-activity.view', 'github-activity.create', 'github-activity.edit',
            'wakatime-activity.view', 'wakatime-activity.create', 'wakatime-activity.edit',
            'laporan.view',
            'dashboard.view',
        ]);
    }
}
