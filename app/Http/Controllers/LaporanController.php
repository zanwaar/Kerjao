<?php

namespace App\Http\Controllers;

use App\Enums\StatusTask;
use App\Models\DailyScrum;
use App\Models\Pegawai;
use App\Models\ProgramKerja;
use App\Models\TodoList;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class LaporanController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()->can('laporan.view'), 403);

        return view('laporan.index', $this->buildReportData($request));
    }

    public function export(Request $request): Response
    {
        abort_unless($request->user()->can('laporan.view'), 403);

        $report = $this->buildReportData($request);

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('laporan.pdf', $report)->setPaper('a4', $report['reportMode'] === 'umum' ? 'portrait' : 'landscape');

        return $pdf->download(
            'laporan-bulanan-'
            . $report['tahun']
            . '-'
            . str_pad((string) $report['bulan'], 2, '0', STR_PAD_LEFT)
            . '.pdf'
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function buildReportData(Request $request): array
    {
        $user = $request->user();
        $reportMode = in_array($request->string('mode')->toString(), ['detail', 'umum'], true)
            ? $request->string('mode')->toString()
            : 'detail';
        $bulan = max(1, min(12, (int) $request->input('bulan', now()->month)));
        $tahun = max(now()->year - 5, min(now()->year + 1, (int) $request->input('tahun', now()->year)));
        $canViewAllTasks = $user->can('task.view-all');

        $periodeMulai = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $periodeSelesai = $periodeMulai->copy()->endOfMonth();

        $pegawaiList = $canViewAllTasks
            ? Pegawai::query()->orderBy('nama_pegawai')->get()
            : collect([$user->pegawai])->filter();

        $programs = ProgramKerja::query()
            ->visibleTo($user)
            ->orderBy('nama_program')
            ->get();

        $pegawaiId = $canViewAllTasks
            ? ($request->filled('pegawai_id') ? (int) $request->input('pegawai_id') : null)
            : $user->pegawai?->id;

        $programId = $request->filled('program_kerja_id')
            ? (int) $request->input('program_kerja_id')
            : null;

        if ($pegawaiId && ! $pegawaiList->contains('id', $pegawaiId)) {
            $pegawaiId = null;
        }

        if ($programId && ! $programs->contains('id', $programId)) {
            $programId = null;
        }

        $selectedPegawai = $pegawaiId
            ? $pegawaiList->firstWhere('id', $pegawaiId)
            : null;

        $selectedProgram = $programId
            ? $programs->firstWhere('id', $programId)
            : null;

        $tasks = $this->buildTaskQuery(
            $request,
            $periodeMulai,
            $periodeSelesai,
            $pegawaiId,
            $programId,
        )->get();

        $scrums = $this->buildScrumQuery(
            $request,
            $periodeMulai,
            $periodeSelesai,
            $pegawaiId,
            $programId,
        )->get();

        $periodeLabel = $periodeMulai->translatedFormat('F Y');
        $summary = $this->buildSummary($tasks, $scrums, $periodeMulai, $periodeSelesai);
        $programReports = $this->buildProgramReports($tasks);
        $evidence = $this->buildEvidence($tasks);
        $analysis = $this->buildAnalysis($summary, $tasks, $scrums);
        $obstacles = $this->buildObstacles($tasks, $scrums);
        $followUps = $this->buildFollowUps($tasks, $scrums);
        $conclusion = $this->buildConclusion($summary, $obstacles);
        $generalReport = $this->buildGeneralReport(
            $tasks,
            $scrums,
            $summary,
            $selectedPegawai,
            $selectedProgram,
            $periodeLabel,
        );

        $queryParams = array_filter([
            'bulan' => $bulan,
            'tahun' => $tahun,
            'mode' => $reportMode,
            'pegawai_id' => $pegawaiId,
            'program_kerja_id' => $programId,
        ], fn ($value) => $value !== null && $value !== '');

        return [
            'tasks' => $tasks,
            'scrums' => $scrums,
            'pegawaiList' => $pegawaiList,
            'programs' => $programs,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'pegawaiId' => $pegawaiId,
            'programId' => $programId,
            'selectedPegawai' => $selectedPegawai,
            'selectedProgram' => $selectedProgram,
            'periodeMulai' => $periodeMulai,
            'periodeSelesai' => $periodeSelesai,
            'periodeLabel' => $periodeLabel,
            'summary' => $summary,
            'programReports' => $programReports,
            'evidence' => $evidence,
            'analysis' => $analysis,
            'obstacles' => $obstacles,
            'followUps' => $followUps,
            'conclusion' => $conclusion,
            'generalReport' => $generalReport,
            'canViewAllTasks' => $canViewAllTasks,
            'generatedAt' => now(),
            'reportMode' => $reportMode,
            'queryParams' => $queryParams,
        ];
    }

    private function buildTaskQuery(
        Request $request,
        Carbon $periodeMulai,
        Carbon $periodeSelesai,
        ?int $pegawaiId,
        ?int $programId,
    ): Builder {
        $tanggalMulai = $periodeMulai->toDateString();
        $tanggalSelesai = $periodeSelesai->toDateString();
        $waktuMulai = $periodeMulai->copy()->startOfDay();
        $waktuSelesai = $periodeSelesai->copy()->endOfDay();

        return TodoList::query()
            ->visibleTo($request->user())
            ->with([
                'kegiatan.programKerja',
                'assignee',
                'buktiAktivitas' => fn ($query) => $query
                    ->when($pegawaiId, fn ($activityQuery) => $activityQuery->where('pegawai_id', $pegawaiId))
                    ->whereBetween('created_at', [$waktuMulai, $waktuSelesai])
                    ->latest(),
                'githubActivities' => fn ($query) => $query
                    ->when($pegawaiId, fn ($activityQuery) => $activityQuery->where('pegawai_id', $pegawaiId))
                    ->whereBetween('commit_time', [$waktuMulai, $waktuSelesai])
                    ->latest('commit_time'),
                'wakatimeActivities' => fn ($query) => $query
                    ->when($pegawaiId, fn ($activityQuery) => $activityQuery->where('pegawai_id', $pegawaiId))
                    ->whereBetween('activity_date', [$tanggalMulai, $tanggalSelesai])
                    ->orderBy('activity_date'),
                'dailyScrums' => fn ($query) => $query
                    ->with('pegawai')
                    ->when($pegawaiId, fn ($activityQuery) => $activityQuery->where('pegawai_id', $pegawaiId))
                    ->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])
                    ->orderBy('tanggal'),
            ])
            ->when($pegawaiId, fn (Builder $query) => $query->where('assigned_to', $pegawaiId))
            ->when($programId, fn (Builder $query) => $query->whereHas('kegiatan', fn (Builder $kegiatanQuery) => $kegiatanQuery->where('program_kerja_id', $programId)))
            ->where(function (Builder $query) use ($pegawaiId, $tanggalMulai, $tanggalSelesai, $waktuMulai, $waktuSelesai): void {
                $query
                    ->whereBetween('created_at', [$waktuMulai, $waktuSelesai])
                    ->orWhereBetween('due_date', [$tanggalMulai, $tanggalSelesai])
                    ->orWhereHas('dailyScrums', function (Builder $scrumQuery) use ($pegawaiId, $tanggalMulai, $tanggalSelesai): void {
                        $scrumQuery
                            ->when($pegawaiId, fn (Builder $pegawaiQuery) => $pegawaiQuery->where('pegawai_id', $pegawaiId))
                            ->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);
                    })
                    ->orWhereHas('buktiAktivitas', function (Builder $buktiQuery) use ($pegawaiId, $waktuMulai, $waktuSelesai): void {
                        $buktiQuery
                            ->when($pegawaiId, fn (Builder $pegawaiQuery) => $pegawaiQuery->where('pegawai_id', $pegawaiId))
                            ->whereBetween('created_at', [$waktuMulai, $waktuSelesai]);
                    })
                    ->orWhereHas('githubActivities', function (Builder $githubQuery) use ($pegawaiId, $waktuMulai, $waktuSelesai): void {
                        $githubQuery
                            ->when($pegawaiId, fn (Builder $pegawaiQuery) => $pegawaiQuery->where('pegawai_id', $pegawaiId))
                            ->whereBetween('commit_time', [$waktuMulai, $waktuSelesai]);
                    })
                    ->orWhereHas('wakatimeActivities', function (Builder $wakatimeQuery) use ($pegawaiId, $tanggalMulai, $tanggalSelesai): void {
                        $wakatimeQuery
                            ->when($pegawaiId, fn (Builder $pegawaiQuery) => $pegawaiQuery->where('pegawai_id', $pegawaiId))
                            ->whereBetween('activity_date', [$tanggalMulai, $tanggalSelesai]);
                    });
            })
            ->orderByRaw('due_date is null')
            ->orderBy('due_date')
            ->orderBy('nama_task');
    }

    private function buildScrumQuery(
        Request $request,
        Carbon $periodeMulai,
        Carbon $periodeSelesai,
        ?int $pegawaiId,
        ?int $programId,
    ): Builder {
        return DailyScrum::query()
            ->with(['pegawai', 'task.kegiatan.programKerja'])
            ->whereBetween('tanggal', [$periodeMulai->toDateString(), $periodeSelesai->toDateString()])
            ->when($pegawaiId, fn (Builder $query) => $query->where('pegawai_id', $pegawaiId))
            ->whereHas('task', function (Builder $query) use ($request, $pegawaiId, $programId): void {
                $query
                    ->visibleTo($request->user())
                    ->when($pegawaiId, fn (Builder $taskQuery) => $taskQuery->where('assigned_to', $pegawaiId))
                    ->when($programId, fn (Builder $taskQuery) => $taskQuery->whereHas('kegiatan', fn (Builder $kegiatanQuery) => $kegiatanQuery->where('program_kerja_id', $programId)));
            })
            ->orderBy('tanggal')
            ->orderBy('id');
    }

    /**
     * @return array<string, int|float>
     */
    private function buildSummary(Collection $tasks, Collection $scrums, Carbon $periodeMulai, Carbon $periodeSelesai): array
    {
        $totalTask = $tasks->count();
        $taskSelesai = $tasks->filter(fn (TodoList $task) => $task->status === StatusTask::Done)->count();
        $taskOnProgress = $tasks->filter(fn (TodoList $task) => $task->status === StatusTask::OnProgress)->count();
        $taskTidakSelesai = $tasks->filter(fn (TodoList $task) => in_array($task->status, [StatusTask::NotStarted, StatusTask::Canceled], true))->count();
        $persentaseCapaian = $totalTask > 0 ? round(($taskSelesai / $totalTask) * 100) : 0;
        $totalHariKerja = collect(CarbonPeriod::create($periodeMulai, $periodeSelesai))
            ->filter(fn (Carbon $tanggal) => $tanggal->isWeekday())
            ->count();

        $githubActivities = $tasks->flatMap->githubActivities;
        $wakatimeActivities = $tasks->flatMap->wakatimeActivities;

        $totalJamKerja = round((float) $wakatimeActivities->sum('duration_hours'), 1);
        $rataRataJamKerja = $totalHariKerja > 0 ? round($totalJamKerja / $totalHariKerja, 1) : 0.0;

        return [
            'total_task' => $totalTask,
            'task_selesai' => $taskSelesai,
            'task_on_progress' => $taskOnProgress,
            'task_tidak_selesai' => $taskTidakSelesai,
            'persentase_capaian' => $persentaseCapaian,
            'total_hari_kerja' => $totalHariKerja,
            'total_jam_kerja' => $totalJamKerja,
            'rata_rata_jam_kerja' => $rataRataJamKerja,
            'total_commit' => $githubActivities->filter(fn ($activity) => filled($activity->commit_hash) || filled($activity->commit_message))->count(),
            'total_pull_request' => $githubActivities->pluck('pr_link')->filter()->unique()->count(),
            'total_issue' => $githubActivities->pluck('issue_link')->filter()->unique()->count(),
            'total_scrum' => $scrums->count(),
        ];
    }

    private function buildProgramReports(Collection $tasks): Collection
    {
        return $tasks
            ->groupBy(fn (TodoList $task) => $task->kegiatan->programKerja->id)
            ->map(function (Collection $programTasks): array {
                $program = $programTasks->first()->kegiatan->programKerja;

                $kegiatanRows = $programTasks
                    ->groupBy('kegiatan_id')
                    ->map(function (Collection $kegiatanTasks): array {
                        $kegiatan = $kegiatanTasks->first()->kegiatan;
                        $taskSelesai = $kegiatanTasks->filter(fn (TodoList $task) => $task->status === StatusTask::Done)->count();
                        $progressRataRata = (int) round($kegiatanTasks->avg('progress_persen'));

                        return [
                            'kegiatan' => $kegiatan,
                            'target' => $kegiatan->target_capaian ?: '-',
                            'realisasi' => sprintf(
                                '%d/%d task selesai · Progress rata-rata %d%%',
                                $taskSelesai,
                                $kegiatanTasks->count(),
                                $progressRataRata,
                            ),
                            'status' => $kegiatan->status_kegiatan->label(),
                        ];
                    })
                    ->values();

                return [
                    'program' => $program,
                    'kegiatan_rows' => $kegiatanRows,
                ];
            })
            ->values();
    }

    /**
     * @return array<string, mixed>
     */
    private function buildEvidence(Collection $tasks): array
    {
        $buktiAktivitas = $tasks->flatMap->buktiAktivitas
            ->sortByDesc('created_at')
            ->values();

        $githubActivities = $tasks->flatMap->githubActivities
            ->sortByDesc(fn ($activity) => $activity->commit_time ?? $activity->created_at)
            ->values();

        $wakatimeActivities = $tasks->flatMap->wakatimeActivities
            ->sortByDesc('activity_date')
            ->values();

        return [
            'bukti_aktivitas' => $buktiAktivitas,
            'github_activities' => $githubActivities,
            'wakatime_activities' => $wakatimeActivities,
            'repos' => $githubActivities->pluck('repo_name')->filter()->unique()->values(),
            'project_durations' => $wakatimeActivities
                ->groupBy('project_name')
                ->map(fn (Collection $activities) => round((float) $activities->sum('duration_hours'), 1))
                ->sortDesc()
                ->take(8),
        ];
    }

    private function buildAnalysis(array $summary, Collection $tasks, Collection $scrums): array
    {
        if ($summary['total_task'] === 0) {
            return ['Tidak ada task yang relevan pada periode ini, sehingga laporan berfokus pada ketersediaan data dan kesiapan tindak lanjut.'];
        }

        $analysis = [
            sprintf(
                'Pada periode ini terdapat %d task dengan %d task selesai dan tingkat capaian %d%%.',
                $summary['total_task'],
                $summary['task_selesai'],
                $summary['persentase_capaian'],
            ),
        ];

        if ($summary['persentase_capaian'] >= 80) {
            $analysis[] = 'Capaian bulanan berada pada kategori baik karena mayoritas target task dapat diselesaikan sesuai rencana.';
        } elseif ($summary['persentase_capaian'] >= 60) {
            $analysis[] = 'Sebagian besar target telah berjalan, namun masih ada area yang perlu dituntaskan agar capaian bulan berikutnya lebih stabil.';
        } else {
            $analysis[] = 'Capaian bulanan masih perlu ditingkatkan karena porsi task yang selesai belum dominan dibanding total pekerjaan.';
        }

        if ($summary['task_on_progress'] > 0) {
            $analysis[] = sprintf(
                'Masih terdapat %d task yang berstatus on progress dan perlu pengawalan sampai selesai pada periode berikutnya.',
                $summary['task_on_progress'],
            );
        }

        if ($summary['total_jam_kerja'] > 0) {
            $analysis[] = sprintf(
                'Aktivitas WakaTime mencatat total %.1f jam kerja dengan rata-rata %.1f jam per hari kerja.',
                $summary['total_jam_kerja'],
                $summary['rata_rata_jam_kerja'],
            );
        }

        if ($summary['total_commit'] > 0) {
            $analysis[] = sprintf(
                'Aktivitas GitHub menunjukkan %d commit, %d pull request, dan %d issue yang tercatat pada periode ini.',
                $summary['total_commit'],
                $summary['total_pull_request'],
                $summary['total_issue'],
            );
        }

        if ($scrums->isNotEmpty()) {
            $analysis[] = sprintf(
                'Daily scrum yang terdokumentasi sebanyak %d entri membantu memantau realisasi harian dan tindak lanjut pekerjaan.',
                $scrums->count(),
            );
        }

        return $analysis;
    }

    private function buildObstacles(Collection $tasks, Collection $scrums): array
    {
        $obstacles = $scrums
            ->pluck('potensi_risiko')
            ->filter()
            ->map(fn (string $item) => trim($item))
            ->unique()
            ->values()
            ->all();

        if (empty($obstacles) && $tasks->contains(fn (TodoList $task) => $task->status !== StatusTask::Done)) {
            $obstacles[] = 'Masih ada task yang belum selesai sehingga perlu prioritas penyelesaian pada periode berikutnya.';
        }

        if (empty($obstacles)) {
            $obstacles[] = 'Tidak ada kendala signifikan yang tercatat pada periode ini.';
        }

        return array_slice($obstacles, 0, 6);
    }

    private function buildFollowUps(Collection $tasks, Collection $scrums): array
    {
        $followUps = $scrums
            ->pluck('rencana_tindak_lanjut')
            ->filter()
            ->map(fn (string $item) => trim($item))
            ->unique()
            ->values()
            ->all();

        if ($tasks->contains(fn (TodoList $task) => $task->status === StatusTask::OnProgress)) {
            $followUps[] = 'Menuntaskan task yang masih on progress sesuai prioritas dan tenggat yang berlaku.';
        }

        if ($tasks->contains(fn (TodoList $task) => in_array($task->status, [StatusTask::NotStarted, StatusTask::Canceled], true))) {
            $followUps[] = 'Melakukan penjadwalan ulang atau penyesuaian ruang lingkup untuk task yang belum selesai.';
        }

        if (empty($followUps)) {
            $followUps[] = 'Mempertahankan ritme kerja dan kualitas dokumentasi aktivitas pada periode selanjutnya.';
        }

        return collect($followUps)
            ->filter()
            ->unique()
            ->values()
            ->take(6)
            ->all();
    }

    private function buildConclusion(array $summary, array $obstacles): string
    {
        if ($summary['total_task'] === 0) {
            return 'Secara umum belum terdapat data aktivitas yang cukup untuk menyusun evaluasi capaian bulanan secara penuh.';
        }

        $hasMeaningfulObstacle = ! (count($obstacles) === 1 && $obstacles[0] === 'Tidak ada kendala signifikan yang tercatat pada periode ini.');

        return sprintf(
            'Secara umum pekerjaan bulan ini mencatat capaian %d%% dengan %d task selesai dari total %d task. %s',
            $summary['persentase_capaian'],
            $summary['task_selesai'],
            $summary['total_task'],
            $hasMeaningfulObstacle
                ? 'Kendala yang muncul telah diidentifikasi untuk ditindaklanjuti pada periode berikutnya.'
                : 'Pelaksanaan pekerjaan berlangsung cukup baik tanpa kendala signifikan yang tercatat.'
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function buildGeneralReport(
        Collection $tasks,
        Collection $scrums,
        array $summary,
        ?Pegawai $selectedPegawai,
        ?ProgramKerja $selectedProgram,
        string $periodeLabel,
    ): array {
        $programHighlights = $tasks
            ->groupBy(fn (TodoList $task) => $task->kegiatan->programKerja->id)
            ->map(function (Collection $programTasks): array {
                $program = $programTasks->first()->kegiatan->programKerja;
                $completedTasks = $programTasks->filter(fn (TodoList $task) => $task->status === StatusTask::Done)->count();
                $averageProgress = (int) round($programTasks->avg('progress_persen'));

                return [
                    'program' => $program,
                    'task_total' => $programTasks->count(),
                    'task_completed' => $completedTasks,
                    'progress' => $averageProgress,
                    'narrative' => sprintf(
                        'Program %s memiliki %d tugas, dengan %d tugas selesai dan progres rata-rata %d%%.',
                        $program->nama_program,
                        $programTasks->count(),
                        $completedTasks,
                        $averageProgress,
                    ),
                ];
            })
            ->values();

        $achievementPoints = $tasks
            ->filter(fn (TodoList $task) => $task->status === StatusTask::Done)
            ->take(6)
            ->map(fn (TodoList $task): string => sprintf(
                'Menyelesaikan %s pada kegiatan %s.',
                $task->nama_task,
                $task->kegiatan->nama_kegiatan,
            ))
            ->values();

        if ($achievementPoints->isEmpty() && $tasks->isNotEmpty()) {
            $achievementPoints = $tasks
                ->take(6)
                ->map(fn (TodoList $task): string => sprintf(
                    'Melanjutkan pekerjaan %s dengan progres %d%%.',
                    $task->nama_task,
                    $task->progress_persen,
                ))
                ->values();
        }

        $activityDigest = $scrums
            ->groupBy(fn (DailyScrum $scrum) => $scrum->tanggal->translatedFormat('d M Y'))
            ->map(function (Collection $dailyScrums, string $tanggal): string {
                $taskNames = $dailyScrums->pluck('task.nama_task')->filter()->unique()->take(2)->join(' dan ');

                return sprintf(
                    '%s berfokus pada %s.',
                    $tanggal,
                    $taskNames !== '' ? $taskNames : 'aktivitas rutin',
                );
            })
            ->take(8)
            ->values();

        $impactPoints = collect([
            sprintf('Pada periode %s tercatat %d pekerjaan utama dengan capaian %d%%.', $periodeLabel, $summary['total_task'], $summary['persentase_capaian']),
            $summary['task_selesai'] > 0
                ? sprintf('%d pekerjaan berhasil diselesaikan sesuai target periode berjalan.', $summary['task_selesai'])
                : 'Belum ada pekerjaan yang selesai penuh pada periode ini, namun proses pengerjaan tetap berjalan.',
            $selectedProgram
                ? sprintf('Laporan ini berfokus pada program %s.', $selectedProgram->nama_program)
                : 'Laporan ini mencakup keseluruhan program yang relevan pada periode berjalan.',
            $selectedPegawai
                ? sprintf('Capaian yang ditampilkan merupakan kontribusi kerja %s.', $selectedPegawai->nama_pegawai)
                : 'Capaian yang ditampilkan merupakan akumulasi pekerjaan dari data yang dipilih.',
        ])->filter()->values();

        return [
            'headline' => sprintf(
                'Laporan umum %s menampilkan ringkasan capaian kerja yang lebih mudah dipahami tanpa rincian teknis mendalam.',
                $periodeLabel,
            ),
            'achievement_points' => $achievementPoints,
            'program_highlights' => $programHighlights,
            'activity_digest' => $activityDigest,
            'impact_points' => $impactPoints,
            'simple_conclusion' => $summary['persentase_capaian'] >= 75
                ? 'Secara umum pekerjaan berjalan baik dan target utama pada periode ini telah tercapai dalam tingkat yang memadai.'
                : 'Secara umum pekerjaan tetap berjalan, namun masih diperlukan penguatan tindak lanjut agar target berikutnya lebih optimal.',
        ];
    }

}
