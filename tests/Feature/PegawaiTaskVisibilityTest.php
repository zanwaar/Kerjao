<?php

use App\Enums\StatusTask;
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

test('pegawai can create their own program kegiatan and task', function () {
    $pegawaiUser = User::factory()->create();
    $pegawaiUser->assignRole('pegawai');
    $pegawai = Pegawai::factory()->create(['user_id' => $pegawaiUser->id]);

    $this->actingAs($pegawaiUser);

    $this->post(route('program-kerja.store'), [
        'nama_program' => 'Program Mandiri Pegawai',
        'deskripsi' => 'Program yang dibuat sendiri oleh pegawai.',
        'waktu_mulai' => '2026-04-01',
        'waktu_selesai' => '2026-04-30',
        'status_program' => 'planning',
    ])->assertRedirect(route('program-kerja.index'));

    $program = ProgramKerja::query()->where('nama_program', 'Program Mandiri Pegawai')->firstOrFail();

    expect($program->created_by)->toBe($pegawaiUser->id);

    $this->post(route('kegiatan.store'), [
        'program_kerja_id' => $program->id,
        'nama_kegiatan' => 'Kegiatan Mandiri Pegawai',
        'deskripsi' => 'Kegiatan yang dibuat di program milik sendiri.',
        'target_capaian' => 'Target pegawai',
        'waktu_mulai' => '2026-04-02',
        'waktu_selesai' => '2026-04-25',
        'status_kegiatan' => 'planning',
    ])->assertRedirect(route('kegiatan.index'));

    $kegiatan = Kegiatan::query()->where('nama_kegiatan', 'Kegiatan Mandiri Pegawai')->firstOrFail();

    expect($kegiatan->created_by)->toBe($pegawaiUser->id);

    $this->post(route('task.store'), [
        'kegiatan_id' => $kegiatan->id,
        'assigned_to' => $pegawai->id,
        'nama_task' => 'Task Mandiri Pegawai',
        'deskripsi_task' => 'Task yang dibuat untuk dirinya sendiri.',
        'status' => 'not_started',
        'prioritas' => 'medium',
        'progress_persen' => 0,
        'due_date' => '2026-04-28',
        'catatan_monev' => null,
    ])->assertRedirect(route('task.index'));

    $task = TodoList::query()->where('nama_task', 'Task Mandiri Pegawai')->firstOrFail();

    expect($task->created_by)->toBe($pegawaiUser->id)
        ->and($task->assigned_to)->toBe($pegawai->id);

    $this->get(route('program-kerja.index'))
        ->assertSuccessful()
        ->assertSee($program->nama_program);

    $this->get(route('kegiatan.index'))
        ->assertSuccessful()
        ->assertSee($kegiatan->nama_kegiatan);

    $this->get(route('task.index'))
        ->assertSuccessful()
        ->assertSee($task->nama_task);
});

test('pegawai cannot create kegiatan in another users program or task for another pegawai', function () {
    $pegawaiUser = User::factory()->create();
    $pegawaiUser->assignRole('pegawai');
    $pegawai = Pegawai::factory()->create(['user_id' => $pegawaiUser->id]);

    $otherUser = User::factory()->create();
    $otherUser->assignRole('pegawai');
    $otherPegawai = Pegawai::factory()->create(['user_id' => $otherUser->id]);

    $otherProgram = ProgramKerja::factory()->create(['created_by' => $otherUser->id]);
    $ownProgram = ProgramKerja::factory()->create(['created_by' => $pegawaiUser->id]);
    $ownKegiatan = Kegiatan::factory()->create([
        'program_kerja_id' => $ownProgram->id,
        'created_by' => $pegawaiUser->id,
    ]);

    $this->actingAs($pegawaiUser);

    $this->post(route('kegiatan.store'), [
        'program_kerja_id' => $otherProgram->id,
        'nama_kegiatan' => 'Kegiatan Tidak Valid',
        'deskripsi' => 'Tidak boleh dibuat.',
        'target_capaian' => 'Target',
        'waktu_mulai' => '2026-04-05',
        'waktu_selesai' => '2026-04-20',
        'status_kegiatan' => 'planning',
    ])->assertSessionHasErrors('program_kerja_id');

    $this->post(route('task.store'), [
        'kegiatan_id' => $ownKegiatan->id,
        'assigned_to' => $otherPegawai->id,
        'nama_task' => 'Task Tidak Valid',
        'deskripsi_task' => 'Tidak boleh dibuat.',
        'status' => 'not_started',
        'prioritas' => 'medium',
        'progress_persen' => 0,
        'due_date' => '2026-04-28',
        'catatan_monev' => null,
    ])->assertSessionHasErrors('assigned_to');

    expect(Kegiatan::query()->where('nama_kegiatan', 'Kegiatan Tidak Valid')->doesntExist())->toBeTrue()
        ->and(TodoList::query()->where('nama_task', 'Task Tidak Valid')->doesntExist())->toBeTrue();
});

test('task status done automatically syncs progress to one hundred percent', function () {
    $pegawaiUser = User::factory()->create();
    $pegawaiUser->assignRole('pegawai');
    $pegawai = Pegawai::factory()->create(['user_id' => $pegawaiUser->id]);
    $program = ProgramKerja::factory()->create(['created_by' => $pegawaiUser->id]);
    $kegiatan = Kegiatan::factory()->create([
        'program_kerja_id' => $program->id,
        'created_by' => $pegawaiUser->id,
    ]);

    $this->actingAs($pegawaiUser);

    $this->post(route('task.store'), [
        'kegiatan_id' => $kegiatan->id,
        'assigned_to' => $pegawai->id,
        'nama_task' => 'Task Sinkron Status',
        'deskripsi_task' => 'Sinkron status ke progress.',
        'status' => 'done',
        'prioritas' => 'medium',
        'progress_persen' => 45,
        'due_date' => '2026-04-28',
        'catatan_monev' => null,
    ])->assertRedirect(route('task.index'));

    $task = TodoList::query()->where('nama_task', 'Task Sinkron Status')->firstOrFail();

    expect($task->status)->toBe(StatusTask::Done)
        ->and($task->progress_persen)->toBe(100);
});

test('task progress one hundred percent automatically syncs status to done on update', function () {
    $pegawaiUser = User::factory()->create();
    $pegawaiUser->assignRole('pegawai');
    $adminUser = User::factory()->create();
    $adminUser->assignRole('admin');
    $pegawai = Pegawai::factory()->create(['user_id' => $pegawaiUser->id]);
    $program = ProgramKerja::factory()->create(['created_by' => $pegawaiUser->id]);
    $kegiatan = Kegiatan::factory()->create([
        'program_kerja_id' => $program->id,
        'created_by' => $pegawaiUser->id,
    ]);
    $task = TodoList::factory()->create([
        'kegiatan_id' => $kegiatan->id,
        'assigned_to' => $pegawai->id,
        'created_by' => $pegawaiUser->id,
        'status' => 'on_progress',
        'progress_persen' => 80,
    ]);

    $this->actingAs($adminUser);

    $this->put(route('task.update', $task), [
        'kegiatan_id' => $kegiatan->id,
        'assigned_to' => $pegawai->id,
        'nama_task' => $task->nama_task,
        'deskripsi_task' => $task->deskripsi_task,
        'status' => 'on_progress',
        'prioritas' => $task->prioritas->value,
        'progress_persen' => 100,
        'due_date' => $task->due_date?->format('Y-m-d'),
        'catatan_monev' => $task->catatan_monev,
    ])->assertRedirect(route('task.show', $task));

    $task->refresh();

    expect($task->status)->toBe(StatusTask::Done)
        ->and($task->progress_persen)->toBe(100);
});

test('pegawai can edit assigned task progress but cannot change locked fields', function () {
    $creatorUser = User::factory()->create();
    $creatorUser->assignRole('pegawai');
    $creatorPegawai = Pegawai::factory()->create(['user_id' => $creatorUser->id]);

    $assignedUser = User::factory()->create();
    $assignedUser->assignRole('pegawai');
    $assignedPegawai = Pegawai::factory()->create(['user_id' => $assignedUser->id]);

    $program = ProgramKerja::factory()->create(['created_by' => $creatorUser->id]);
    $kegiatan = Kegiatan::factory()->create([
        'program_kerja_id' => $program->id,
        'created_by' => $creatorUser->id,
    ]);
    $task = TodoList::factory()->create([
        'kegiatan_id' => $kegiatan->id,
        'assigned_to' => $assignedPegawai->id,
        'created_by' => $creatorUser->id,
        'nama_task' => 'Task Operasional Pegawai',
        'status' => 'on_progress',
        'progress_persen' => 40,
        'catatan_monev' => null,
    ]);

    $this->actingAs($assignedUser);

    $this->get(route('task.edit', $task))
        ->assertSuccessful()
        ->assertSee('Anda bisa memperbarui progres task Anda sendiri.')
        ->assertDontSee('name="nama_task"', false);

    $this->put(route('task.update', $task), [
        'nama_task' => 'Task Diubah Tanpa Izin',
        'status' => 'done',
        'progress_persen' => 75,
        'catatan_monev' => 'Progres selesai oleh pegawai pelaksana.',
    ])->assertRedirect(route('task.show', $task));

    $task->refresh();

    expect($task->nama_task)->toBe('Task Operasional Pegawai')
        ->and($task->status)->toBe(StatusTask::Done)
        ->and($task->progress_persen)->toBe(100)
        ->and($task->catatan_monev)->toBe('Progres selesai oleh pegawai pelaksana.');
});

test('pegawai sidebar focuses on task saya and task saya page has create button', function () {
    $pegawaiUser = User::factory()->create();
    $pegawaiUser->assignRole('pegawai');
    Pegawai::factory()->create(['user_id' => $pegawaiUser->id]);

    $this->actingAs($pegawaiUser);

    $this->get(route('dashboard'))
        ->assertSuccessful()
        ->assertSee('<a href="'.route('task.saya').'"', false)
        ->assertDontSee('<a href="'.route('task.index').'"', false);

    $this->get(route('task.saya'))
        ->assertSuccessful()
        ->assertSee('Tambah Task')
        ->assertSee(route('task.create'), false);
});

test('pegawai can filter task saya by program kerja', function () {
    $pegawaiUser = User::factory()->create();
    $pegawaiUser->assignRole('pegawai');
    $pegawai = Pegawai::factory()->create(['user_id' => $pegawaiUser->id]);

    $programA = ProgramKerja::factory()->create(['nama_program' => 'Program A']);
    $programB = ProgramKerja::factory()->create(['nama_program' => 'Program B']);

    $kegiatanA = Kegiatan::factory()->create(['program_kerja_id' => $programA->id]);
    $kegiatanB = Kegiatan::factory()->create(['program_kerja_id' => $programB->id]);

    $taskA = TodoList::factory()->create([
        'kegiatan_id' => $kegiatanA->id,
        'assigned_to' => $pegawai->id,
        'nama_task' => 'Task Program A',
    ]);

    $taskB = TodoList::factory()->create([
        'kegiatan_id' => $kegiatanB->id,
        'assigned_to' => $pegawai->id,
        'nama_task' => 'Task Program B',
    ]);

    $this->actingAs($pegawaiUser);

    $this->get(route('task.saya', ['program_kerja_id' => $programA->id]))
        ->assertSuccessful()
        ->assertSee('Program A')
        ->assertSee($taskA->nama_task)
        ->assertDontSee($taskB->nama_task);
});
