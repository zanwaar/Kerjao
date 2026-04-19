<?php

namespace Database\Seeders;

use App\Enums\PrioritasTask;
use App\Enums\StatusKegiatan;
use App\Enums\StatusProgram;
use App\Enums\StatusTask;
use App\Models\DailyScrum;
use App\Models\Kegiatan;
use App\Models\Pegawai;
use App\Models\ProgramKerja;
use App\Models\TodoList;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $adminUser = User::where('email', 'admin@kerjao.test')->firstOrFail();
        $pimpinanUser = User::where('email', 'pimpinan@kerjao.test')->firstOrFail();

        $pegawaiList = Pegawai::whereHas('user', fn ($q) => $q->whereIn('email', [
            'pegawai1@kerjao.test',
            'pegawai2@kerjao.test',
            'pegawai3@kerjao.test',
        ]))->get();

        // === PROGRAM KERJA ===
        $programs = [
            [
                'nama_program' => 'Pengembangan Sistem Informasi Kepegawaian',
                'deskripsi' => 'Program pengembangan dan pemeliharaan sistem informasi kepegawaian berbasis web untuk mendukung pengelolaan data ASN secara digital.',
                'waktu_mulai' => '2026-01-01',
                'waktu_selesai' => '2026-06-30',
                'status_program' => StatusProgram::Active,
                'kegiatan' => [
                    [
                        'nama_kegiatan' => 'Analisis Kebutuhan Sistem',
                        'deskripsi' => 'Analisis dan dokumentasi kebutuhan fungsional dan non-fungsional sistem.',
                        'status_kegiatan' => StatusKegiatan::Completed,
                        'tasks' => [
                            ['nama' => 'Pengumpulan data kebutuhan dari stakeholder', 'status' => StatusTask::Done, 'progres' => 100, 'prioritas' => PrioritasTask::High, 'offset_days' => -45],
                            ['nama' => 'Penyusunan dokumen SRS', 'status' => StatusTask::Done, 'progres' => 100, 'prioritas' => PrioritasTask::High, 'offset_days' => -35],
                            ['nama' => 'Review dan validasi SRS bersama pimpinan', 'status' => StatusTask::Done, 'progres' => 100, 'prioritas' => PrioritasTask::Medium, 'offset_days' => -28],
                        ],
                    ],
                    [
                        'nama_kegiatan' => 'Desain dan Pengembangan Frontend',
                        'deskripsi' => 'Pembuatan antarmuka pengguna menggunakan Blade dan Tailwind CSS.',
                        'status_kegiatan' => StatusKegiatan::Active,
                        'tasks' => [
                            ['nama' => 'Desain wireframe dan mockup UI', 'status' => StatusTask::Done, 'progres' => 100, 'prioritas' => PrioritasTask::High, 'offset_days' => -20],
                            ['nama' => 'Implementasi layout dan komponen utama', 'status' => StatusTask::Done, 'progres' => 100, 'prioritas' => PrioritasTask::High, 'offset_days' => -10],
                            ['nama' => 'Pengembangan halaman dashboard', 'status' => StatusTask::OnProgress, 'progres' => 70, 'prioritas' => PrioritasTask::High, 'offset_days' => 5],
                            ['nama' => 'Pengembangan halaman manajemen pegawai', 'status' => StatusTask::OnProgress, 'progres' => 50, 'prioritas' => PrioritasTask::Medium, 'offset_days' => 10],
                            ['nama' => 'Integrasi notifikasi dan alert', 'status' => StatusTask::NotStarted, 'progres' => 0, 'prioritas' => PrioritasTask::Low, 'offset_days' => 20],
                        ],
                    ],
                    [
                        'nama_kegiatan' => 'Pengembangan Backend dan API',
                        'deskripsi' => 'Implementasi business logic, REST API, dan integrasi database.',
                        'status_kegiatan' => StatusKegiatan::Active,
                        'tasks' => [
                            ['nama' => 'Setup struktur proyek Laravel', 'status' => StatusTask::Done, 'progres' => 100, 'prioritas' => PrioritasTask::High, 'offset_days' => -25],
                            ['nama' => 'Implementasi autentikasi dan otorisasi', 'status' => StatusTask::Done, 'progres' => 100, 'prioritas' => PrioritasTask::High, 'offset_days' => -15],
                            ['nama' => 'Pengembangan CRUD modul kepegawaian', 'status' => StatusTask::OnProgress, 'progres' => 80, 'prioritas' => PrioritasTask::High, 'offset_days' => 7],
                            ['nama' => 'Implementasi laporan dan ekspor PDF', 'status' => StatusTask::OnProgress, 'progres' => 30, 'prioritas' => PrioritasTask::Medium, 'offset_days' => 15],
                        ],
                    ],
                ],
            ],
            [
                'nama_program' => 'Peningkatan Infrastruktur Jaringan Internal',
                'deskripsi' => 'Program pembaruan dan optimasi infrastruktur jaringan komputer di lingkungan kantor untuk mendukung produktivitas kerja.',
                'waktu_mulai' => '2026-02-01',
                'waktu_selesai' => '2026-07-31',
                'status_program' => StatusProgram::Active,
                'kegiatan' => [
                    [
                        'nama_kegiatan' => 'Audit Infrastruktur Eksisting',
                        'deskripsi' => 'Penilaian kondisi jaringan, server, dan perangkat pendukung yang ada.',
                        'status_kegiatan' => StatusKegiatan::Completed,
                        'tasks' => [
                            ['nama' => 'Inventarisasi perangkat jaringan', 'status' => StatusTask::Done, 'progres' => 100, 'prioritas' => PrioritasTask::High, 'offset_days' => -50],
                            ['nama' => 'Pengujian kecepatan dan stabilitas jaringan', 'status' => StatusTask::Done, 'progres' => 100, 'prioritas' => PrioritasTask::Medium, 'offset_days' => -40],
                            ['nama' => 'Penyusunan laporan audit', 'status' => StatusTask::Done, 'progres' => 100, 'prioritas' => PrioritasTask::Medium, 'offset_days' => -30],
                        ],
                    ],
                    [
                        'nama_kegiatan' => 'Pemasangan dan Konfigurasi Perangkat Baru',
                        'deskripsi' => 'Pengadaan dan instalasi switch, router, dan access point baru.',
                        'status_kegiatan' => StatusKegiatan::Active,
                        'tasks' => [
                            ['nama' => 'Pengadaan perangkat jaringan', 'status' => StatusTask::Done, 'progres' => 100, 'prioritas' => PrioritasTask::High, 'offset_days' => -18],
                            ['nama' => 'Instalasi switch layer 2 di setiap lantai', 'status' => StatusTask::OnProgress, 'progres' => 60, 'prioritas' => PrioritasTask::High, 'offset_days' => 8],
                            ['nama' => 'Konfigurasi VLAN dan routing', 'status' => StatusTask::NotStarted, 'progres' => 0, 'prioritas' => PrioritasTask::High, 'offset_days' => 18],
                            ['nama' => 'Uji coba konektivitas menyeluruh', 'status' => StatusTask::NotStarted, 'progres' => 0, 'prioritas' => PrioritasTask::Medium, 'offset_days' => 25],
                        ],
                    ],
                ],
            ],
        ];

        $allTasks = [];

        foreach ($programs as $progData) {
            $program = ProgramKerja::create([
                'created_by' => $adminUser->id,
                'nama_program' => $progData['nama_program'],
                'deskripsi' => $progData['deskripsi'],
                'waktu_mulai' => $progData['waktu_mulai'],
                'waktu_selesai' => $progData['waktu_selesai'],
                'status_program' => $progData['status_program'],
            ]);

            foreach ($progData['kegiatan'] as $kegData) {
                $kegiatan = Kegiatan::create([
                    'program_kerja_id' => $program->id,
                    'created_by' => $adminUser->id,
                    'nama_kegiatan' => $kegData['nama_kegiatan'],
                    'deskripsi' => $kegData['deskripsi'],
                    'status_kegiatan' => $kegData['status_kegiatan'],
                    'waktu_mulai' => $kegData['waktu_mulai'] ?? $progData['waktu_mulai'],
                    'waktu_selesai' => $kegData['waktu_selesai'] ?? $progData['waktu_selesai'],
                ]);

                $pegawaiCycle = $pegawaiList->values();
                $pegIdx = 0;

                foreach ($kegData['tasks'] as $taskData) {
                    $assignee = $pegawaiCycle[$pegIdx % $pegawaiCycle->count()];
                    $pegIdx++;

                    $dueDate = now()->addDays($taskData['offset_days']);
                    $createdAt = $taskData['status'] === StatusTask::Done
                        ? Carbon::create(2026, 3, rand(1, 15))
                        : Carbon::create(2026, 3, rand(16, 31));

                    $task = TodoList::create([
                        'kegiatan_id' => $kegiatan->id,
                        'assigned_to' => $assignee->id,
                        'created_by' => $adminUser->id,
                        'nama_task' => $taskData['nama'],
                        'deskripsi_task' => 'Deskripsi detail untuk task: ' . $taskData['nama'],
                        'status' => $taskData['status'],
                        'prioritas' => $taskData['prioritas'],
                        'progress_persen' => $taskData['progres'],
                        'due_date' => $dueDate,
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt,
                    ]);

                    $allTasks[] = ['task' => $task, 'assignee' => $assignee];
                }
            }
        }

        // === DAILY SCRUM — Senin s/d Jumat, Maret - April 2026 ===
        $scrumStart = Carbon::create(2026, 3, 1);
        $scrumEnd = Carbon::create(2026, 4, 18); // hari ini

        $period = CarbonPeriod::create($scrumStart, $scrumEnd)->filter(
            fn (Carbon $date) => $date->isWeekday()
        );

        $rencanaPool = [
            'Melanjutkan pengerjaan task yang belum selesai',
            'Melakukan review kode dan perbaikan bug',
            'Diskusi teknis dengan tim terkait implementasi',
            'Menyiapkan dokumentasi teknis',
            'Testing dan validasi fitur',
            'Koordinasi dengan unit terkait',
        ];

        $realisasiPool = [
            'Berhasil menyelesaikan sebagian besar target hari ini',
            'Menemukan dan memperbaiki beberapa bug pada modul',
            'Implementasi fitur berjalan sesuai rencana',
            'Dokumentasi berhasil diperbarui',
            'Pengujian selesai dengan hasil memuaskan',
        ];

        $riskoPool = [
            null,
            null,
            'Ketergantungan pada modul lain yang belum selesai',
            'Kebutuhan klarifikasi dari pimpinan',
            null,
            'Potensi keterlambatan jika ada perubahan requirement',
        ];

        foreach ($period as $date) {
            // Setiap pegawai isi 1-2 scrum per hari
            foreach ($pegawaiList as $pegawai) {
                // Pilih task yang di-assign ke pegawai ini, atau random
                $pegawaiTasks = collect($allTasks)
                    ->filter(fn ($t) => $t['assignee']->id === $pegawai->id)
                    ->values();

                if ($pegawaiTasks->isEmpty()) {
                    continue;
                }

                $taskEntry = $pegawaiTasks->random();

                DailyScrum::create([
                    'pegawai_id' => $pegawai->id,
                    'task_id' => $taskEntry['task']->id,
                    'tanggal' => $date->toDateString(),
                    'rencana_kerja_harian' => $rencanaPool[array_rand($rencanaPool)] . ' - ' . $taskEntry['task']->nama_task,
                    'indikator_capaian' => 'Penyelesaian minimal 20% dari target task hari ini',
                    'potensi_risiko' => $riskoPool[array_rand($riskoPool)],
                    'realisasi' => $date->isPast() ? $realisasiPool[array_rand($realisasiPool)] : null,
                    'rencana_tindak_lanjut' => $date->isPast() ? $rencanaPool[array_rand($rencanaPool)] : null,
                ]);
            }
        }
    }
}
