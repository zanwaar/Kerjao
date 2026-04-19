<?php

use App\Models\BuktiAktivitas;
use App\Models\DailyScrum;
use App\Models\GithubActivity;
use App\Models\Kegiatan;
use App\Models\Pegawai;
use App\Models\ProgramKerja;
use App\Models\TodoList;
use App\Models\User;
use App\Models\WakatimeActivity;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

uses(RefreshDatabase::class);

beforeEach(function () {
    Carbon::setTestNow('2026-03-15 10:00:00');

    $this->seed(RolePermissionSeeder::class);
});

afterEach(function () {
    Carbon::setTestNow();
});

test('pegawai report preview only shows their own monthly work data', function () {
    $pegawaiUser = User::factory()->create();
    $pegawaiUser->assignRole('pegawai');
    $pegawai = Pegawai::factory()->create([
        'user_id' => $pegawaiUser->id,
        'nama_pegawai' => 'Andi',
        'jabatan' => 'Programmer',
        'unit_kerja' => 'Bidang TI',
    ]);

    $otherUser = User::factory()->create();
    $otherUser->assignRole('pegawai');
    $otherPegawai = Pegawai::factory()->create([
        'user_id' => $otherUser->id,
        'nama_pegawai' => 'Budi',
    ]);

    $myProgram = ProgramKerja::factory()->create([
        'nama_program' => 'Digitalisasi Laporan',
    ]);
    $otherProgram = ProgramKerja::factory()->create([
        'nama_program' => 'Sistem Kepegawaian',
    ]);

    $myKegiatan = Kegiatan::factory()->create([
        'program_kerja_id' => $myProgram->id,
        'nama_kegiatan' => 'Pengembangan Sistem',
    ]);
    $otherKegiatan = Kegiatan::factory()->create([
        'program_kerja_id' => $otherProgram->id,
        'nama_kegiatan' => 'Migrasi Data',
    ]);

    $myTask = TodoList::factory()->done()->create([
        'kegiatan_id' => $myKegiatan->id,
        'assigned_to' => $pegawai->id,
        'created_by' => $pegawaiUser->id,
        'nama_task' => 'UI Dashboard',
        'created_at' => now()->copy()->subDays(3),
        'due_date' => now()->copy()->addDays(5),
    ]);

    $otherTask = TodoList::factory()->create([
        'kegiatan_id' => $otherKegiatan->id,
        'assigned_to' => $otherPegawai->id,
        'created_by' => $otherUser->id,
        'nama_task' => 'Sinkronisasi Data',
        'created_at' => now()->copy()->subDays(2),
        'due_date' => now()->copy()->addDays(7),
    ]);

    DailyScrum::factory()->create([
        'pegawai_id' => $pegawai->id,
        'task_id' => $myTask->id,
        'tanggal' => now()->toDateString(),
        'rencana_kerja_harian' => 'Menyelesaikan UI dashboard',
        'realisasi' => 'Selesai 100%',
    ]);

    GithubActivity::factory()->create([
        'pegawai_id' => $pegawai->id,
        'task_id' => $myTask->id,
        'repo_name' => 'kerjao/app',
        'commit_message' => 'feat: complete dashboard report',
        'commit_time' => now()->copy()->subDay(),
    ]);

    WakatimeActivity::factory()->create([
        'pegawai_id' => $pegawai->id,
        'task_id' => $myTask->id,
        'project_name' => 'kerjao',
        'duration_hours' => 4.5,
        'activity_date' => now()->toDateString(),
    ]);

    BuktiAktivitas::factory()->create([
        'pegawai_id' => $pegawai->id,
        'task_id' => $myTask->id,
        'sumber_bukti' => 'https://example.test/report/dashboard',
    ]);

    DailyScrum::factory()->create([
        'pegawai_id' => $otherPegawai->id,
        'task_id' => $otherTask->id,
        'tanggal' => now()->toDateString(),
        'rencana_kerja_harian' => 'Migrasi data pegawai',
    ]);

    $this->actingAs($pegawaiUser)
        ->get(route('laporan.index', [
            'bulan' => 3,
            'tahun' => 2026,
            'pegawai_id' => $otherPegawai->id,
        ]))
        ->assertSuccessful()
        ->assertSee('Identitas Laporan')
        ->assertSee('Andi')
        ->assertSee('Digitalisasi Laporan')
        ->assertSee('Pengembangan Sistem')
        ->assertSee('UI Dashboard')
        ->assertDontSee('Budi')
        ->assertDontSee('Sistem Kepegawaian')
        ->assertDontSee('Migrasi Data')
        ->assertDontSee('Sinkronisasi Data');
});

test('general report preview uses non technical mode and still only shows employee work data', function () {
    $pegawaiUser = User::factory()->create();
    $pegawaiUser->assignRole('pegawai');
    $pegawai = Pegawai::factory()->create([
        'user_id' => $pegawaiUser->id,
        'nama_pegawai' => 'Andi',
        'jabatan' => 'Programmer',
        'unit_kerja' => 'Bidang TI',
    ]);

    $otherUser = User::factory()->create();
    $otherUser->assignRole('pegawai');
    $otherPegawai = Pegawai::factory()->create([
        'user_id' => $otherUser->id,
        'nama_pegawai' => 'Budi',
    ]);

    $myProgram = ProgramKerja::factory()->create([
        'nama_program' => 'Digitalisasi Laporan',
    ]);
    $otherProgram = ProgramKerja::factory()->create([
        'nama_program' => 'Sistem Kepegawaian',
    ]);

    $myKegiatan = Kegiatan::factory()->create([
        'program_kerja_id' => $myProgram->id,
        'nama_kegiatan' => 'Pengembangan Sistem',
    ]);
    $otherKegiatan = Kegiatan::factory()->create([
        'program_kerja_id' => $otherProgram->id,
        'nama_kegiatan' => 'Migrasi Data',
    ]);

    $myTask = TodoList::factory()->done()->create([
        'kegiatan_id' => $myKegiatan->id,
        'assigned_to' => $pegawai->id,
        'created_by' => $pegawaiUser->id,
        'nama_task' => 'UI Dashboard',
        'created_at' => now()->copy()->subDays(3),
        'due_date' => now()->copy()->addDays(5),
    ]);

    $otherTask = TodoList::factory()->create([
        'kegiatan_id' => $otherKegiatan->id,
        'assigned_to' => $otherPegawai->id,
        'created_by' => $otherUser->id,
        'nama_task' => 'Sinkronisasi Data',
        'created_at' => now()->copy()->subDays(2),
        'due_date' => now()->copy()->addDays(7),
    ]);

    DailyScrum::factory()->create([
        'pegawai_id' => $pegawai->id,
        'task_id' => $myTask->id,
        'tanggal' => now()->toDateString(),
        'rencana_kerja_harian' => 'Menyelesaikan UI dashboard',
        'realisasi' => 'Selesai 100%',
    ]);

    DailyScrum::factory()->create([
        'pegawai_id' => $otherPegawai->id,
        'task_id' => $otherTask->id,
        'tanggal' => now()->toDateString(),
        'rencana_kerja_harian' => 'Migrasi data pegawai',
    ]);

    $this->actingAs($pegawaiUser)
        ->get(route('laporan.index', [
            'bulan' => 3,
            'tahun' => 2026,
            'mode' => 'umum',
            'pegawai_id' => $otherPegawai->id,
        ]))
        ->assertSuccessful()
        ->assertSee('Mode Umum')
        ->assertSee('Kesimpulan Umum')
        ->assertSee('Andi')
        ->assertSee('Digitalisasi Laporan')
        ->assertSee('UI Dashboard')
        ->assertDontSee('Budi')
        ->assertDontSee('Sistem Kepegawaian')
        ->assertDontSee('Migrasi Data')
        ->assertDontSee('Sinkronisasi Data');
});

test('monthly report export returns a pdf download', function () {
    $user = User::factory()->create();
    $user->assignRole('pegawai');
    $pegawai = Pegawai::factory()->create([
        'user_id' => $user->id,
        'nama_pegawai' => 'Andi',
    ]);

    $program = ProgramKerja::factory()->create([
        'nama_program' => 'Digitalisasi Laporan',
    ]);

    $kegiatan = Kegiatan::factory()->create([
        'program_kerja_id' => $program->id,
        'nama_kegiatan' => 'Pengembangan Sistem',
    ]);

    $task = TodoList::factory()->done()->create([
        'kegiatan_id' => $kegiatan->id,
        'assigned_to' => $pegawai->id,
        'created_by' => $user->id,
        'nama_task' => 'Desain Database',
        'created_at' => now()->copy()->subDays(4),
        'due_date' => now()->copy()->addDays(4),
    ]);

    DailyScrum::factory()->create([
        'pegawai_id' => $pegawai->id,
        'task_id' => $task->id,
        'tanggal' => now()->toDateString(),
        'rencana_kerja_harian' => 'Buat ERD final',
    ]);

    $response = $this->actingAs($user)->get(route('laporan.export', [
        'bulan' => 3,
        'tahun' => 2026,
    ]));

    $response->assertSuccessful();
    expect($response->headers->get('content-type'))->toContain('application/pdf');
    expect($response->headers->get('content-disposition'))->toContain('laporan-bulanan-2026-03.pdf');
    expect(substr($response->getContent(), 0, 4))->toBe('%PDF');
});

test('general monthly report export returns a pdf download', function () {
    $user = User::factory()->create();
    $user->assignRole('pegawai');
    $pegawai = Pegawai::factory()->create([
        'user_id' => $user->id,
        'nama_pegawai' => 'Andi',
    ]);

    $program = ProgramKerja::factory()->create([
        'nama_program' => 'Digitalisasi Laporan',
    ]);

    $kegiatan = Kegiatan::factory()->create([
        'program_kerja_id' => $program->id,
        'nama_kegiatan' => 'Pengembangan Sistem',
    ]);

    $task = TodoList::factory()->done()->create([
        'kegiatan_id' => $kegiatan->id,
        'assigned_to' => $pegawai->id,
        'created_by' => $user->id,
        'nama_task' => 'Desain Database',
        'created_at' => now()->copy()->subDays(4),
        'due_date' => now()->copy()->addDays(4),
    ]);

    DailyScrum::factory()->create([
        'pegawai_id' => $pegawai->id,
        'task_id' => $task->id,
        'tanggal' => now()->toDateString(),
        'rencana_kerja_harian' => 'Buat ERD final',
    ]);

    $response = $this->actingAs($user)->get(route('laporan.export', [
        'bulan' => 3,
        'tahun' => 2026,
        'mode' => 'umum',
    ]));

    $response->assertSuccessful();
    expect($response->headers->get('content-type'))->toContain('application/pdf');
    expect($response->headers->get('content-disposition'))->toContain('laporan-bulanan-2026-03.pdf');
    expect(substr($response->getContent(), 0, 4))->toBe('%PDF');
});
