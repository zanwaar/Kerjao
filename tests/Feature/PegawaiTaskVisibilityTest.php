<?php

use App\Models\Kegiatan;
use App\Models\Pegawai;
use App\Models\ProgramKerja;
use App\Models\TodoList;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('pegawai only sees tasks programs and kegiatan related to their assignments', function () {
    $pegawaiUser = User::factory()->create();
    $pegawaiUser->assignRole('pegawai');
    $pegawai = Pegawai::factory()->create(['user_id' => $pegawaiUser->id]);

    $otherUser = User::factory()->create();
    $otherUser->assignRole('pegawai');
    $otherPegawai = Pegawai::factory()->create(['user_id' => $otherUser->id]);

    $myProgram = ProgramKerja::factory()->active()->create();
    $otherProgram = ProgramKerja::factory()->active()->create();

    $myKegiatan = Kegiatan::factory()->active()->create(['program_kerja_id' => $myProgram->id]);
    $otherKegiatan = Kegiatan::factory()->active()->create(['program_kerja_id' => $otherProgram->id]);

    $myTask = TodoList::factory()->create([
        'kegiatan_id' => $myKegiatan->id,
        'assigned_to' => $pegawai->id,
    ]);

    $otherTask = TodoList::factory()->create([
        'kegiatan_id' => $otherKegiatan->id,
        'assigned_to' => $otherPegawai->id,
    ]);

    $this->actingAs($pegawaiUser);

    $this->get(route('task.index'))
        ->assertSuccessful()
        ->assertSee($myTask->nama_task)
        ->assertSee($myProgram->nama_program)
        ->assertSee($myKegiatan->nama_kegiatan)
        ->assertDontSee($otherTask->nama_task)
        ->assertDontSee($otherProgram->nama_program)
        ->assertDontSee($otherKegiatan->nama_kegiatan);

    $this->get(route('program-kerja.index'))
        ->assertSuccessful()
        ->assertSee($myProgram->nama_program)
        ->assertDontSee($otherProgram->nama_program);

    $this->get(route('kegiatan.index'))
        ->assertSuccessful()
        ->assertSee($myKegiatan->nama_kegiatan)
        ->assertDontSee($otherKegiatan->nama_kegiatan);
});

test('pegawai cannot open unrelated task program or kegiatan details', function () {
    $pegawaiUser = User::factory()->create();
    $pegawaiUser->assignRole('pegawai');
    $pegawai = Pegawai::factory()->create(['user_id' => $pegawaiUser->id]);

    $otherUser = User::factory()->create();
    $otherUser->assignRole('pegawai');
    $otherPegawai = Pegawai::factory()->create(['user_id' => $otherUser->id]);

    $myProgram = ProgramKerja::factory()->active()->create();
    $otherProgram = ProgramKerja::factory()->active()->create();

    $myKegiatan = Kegiatan::factory()->active()->create(['program_kerja_id' => $myProgram->id]);
    $otherKegiatan = Kegiatan::factory()->active()->create(['program_kerja_id' => $otherProgram->id]);

    TodoList::factory()->create([
        'kegiatan_id' => $myKegiatan->id,
        'assigned_to' => $pegawai->id,
    ]);

    $otherTask = TodoList::factory()->create([
        'kegiatan_id' => $otherKegiatan->id,
        'assigned_to' => $otherPegawai->id,
    ]);

    $this->actingAs($pegawaiUser);

    $this->get(route('task.show', $otherTask))->assertNotFound();
    $this->get(route('program-kerja.show', $otherProgram))->assertNotFound();
    $this->get(route('kegiatan.show', $otherKegiatan))->assertNotFound();
});
