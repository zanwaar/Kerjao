<?php

namespace App\Http\Controllers;

use App\Enums\StatusPegawai;
use App\Enums\StatusTask;
use App\Models\DailyScrum;
use App\Models\Kegiatan;
use App\Models\Pegawai;
use App\Models\ProgramKerja;
use App\Models\TodoList;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()->can('dashboard.view'), 403);

        $user = $request->user();
        $pegawai = $user->pegawai;
        $canViewAllTasks = $user->can('task.view-all');
        $selectedPegawai = null;
        $pegawaiOptions = collect();

        if ($canViewAllTasks) {
            $pegawaiOptions = Pegawai::query()
                ->where('status_pegawai', StatusPegawai::Aktif)
                ->orderBy('nama_pegawai')
                ->get();

            $selectedPegawai = $request->filled('pegawai_id')
                ? $pegawaiOptions->firstWhere('id', (int) $request->input('pegawai_id'))
                : null;
        }

        $totalProgramAktif = ProgramKerja::query()
            ->visibleTo($user)
            ->when($selectedPegawai, fn ($query) => $query->whereHas('kegiatan.tasks', fn ($taskQuery) => $taskQuery->assignedTo($selectedPegawai->id)))
            ->where('status_program', 'active')
            ->count();

        $totalKegiatanAktif = Kegiatan::query()
            ->visibleTo($user)
            ->when($selectedPegawai, fn ($query) => $query->whereHas('tasks', fn ($taskQuery) => $taskQuery->assignedTo($selectedPegawai->id)))
            ->where('status_kegiatan', 'active')
            ->count();

        $visibleTasks = TodoList::query()
            ->visibleTo($user)
            ->when($selectedPegawai, fn ($query) => $query->assignedTo($selectedPegawai->id));

        $totalTask = (clone $visibleTasks)->count();
        $taskSelesai = (clone $visibleTasks)->where('status', StatusTask::Done)->count();
        $taskOnProgress = (clone $visibleTasks)->where('status', StatusTask::OnProgress)->count();
        $taskOverdue = TodoList::query()
            ->visibleTo($user)
            ->when($selectedPegawai, fn ($query) => $query->assignedTo($selectedPegawai->id))
            ->overdue()
            ->with(['assignee', 'kegiatan.programKerja'])
            ->latest()
            ->take(10)
            ->get();

        $scrumHariIni = collect();
        $taskSaya = collect();
        $totalPegawaiAktif = 0;
        $aktivitasPegawai = collect();
        $programMonitor = collect();
        $scrumTerbaru = collect();
        $selectedPegawaiTasks = collect();

        if ($canViewAllTasks) {
            $today = today();

            $totalPegawaiAktif = $pegawaiOptions->count();

            $aktivitasPegawai = Pegawai::query()
                ->whereKey($pegawaiOptions->pluck('id'))
                ->withCount([
                    'tasks as task_aktif_count' => fn ($query) => $query->whereIn('status', [
                        StatusTask::NotStarted->value,
                        StatusTask::OnProgress->value,
                    ]),
                    'tasks as task_selesai_count' => fn ($query) => $query->where('status', StatusTask::Done->value),
                    'dailyScrums as scrum_hari_ini_count' => fn ($query) => $query->whereDate('tanggal', $today),
                    'buktiAktivitas as bukti_hari_ini_count' => fn ($query) => $query->whereDate('created_at', $today),
                    'githubActivities as github_hari_ini_count' => fn ($query) => $query->whereDate('commit_time', $today),
                    'wakatimeActivities as wakatime_hari_ini_count' => fn ($query) => $query->whereDate('activity_date', $today),
                ])
                ->orderByDesc('scrum_hari_ini_count')
                ->orderByDesc('task_aktif_count')
                ->orderBy('nama_pegawai')
                ->take(8)
                ->get();

            $programMonitor = ProgramKerja::query()
                ->visibleTo($user)
                ->when($selectedPegawai, fn ($query) => $query->whereHas('kegiatan.tasks', fn ($taskQuery) => $taskQuery->assignedTo($selectedPegawai->id)))
                ->with([
                    'kegiatan.tasks' => fn ($query) => $query
                        ->when($selectedPegawai, fn ($taskQuery) => $taskQuery->assignedTo($selectedPegawai->id))
                        ->select([
                            'id',
                            'kegiatan_id',
                            'assigned_to',
                            'status',
                            'progress_persen',
                        ]),
                ])
                ->latest()
                ->take(6)
                ->get();

            $scrumTerbaru = DailyScrum::query()
                ->with(['pegawai', 'task.kegiatan.programKerja'])
                ->when($selectedPegawai, fn ($query) => $query->where('pegawai_id', $selectedPegawai->id))
                ->whereHas('task', fn ($query) => $query->visibleTo($user))
                ->latest('tanggal')
                ->latest('id')
                ->take(8)
                ->get();

            $selectedPegawaiTasks = TodoList::query()
                ->visibleTo($user)
                ->when($selectedPegawai, fn ($query) => $query->assignedTo($selectedPegawai->id), fn ($query) => $query->whereRaw('1 = 0'))
                ->with(['kegiatan.programKerja'])
                ->withCount('dailyScrums')
                ->latest()
                ->take(8)
                ->get();
        }

        if ($pegawai) {
            $scrumHariIni = DailyScrum::where('pegawai_id', $pegawai->id)
                ->whereDate('tanggal', today())
                ->with('task')
                ->get();

            $taskSaya = TodoList::assignedTo($pegawai->id)
                ->whereNotIn('status', [StatusTask::Done->value, StatusTask::Canceled->value])
                ->with('kegiatan.programKerja')
                ->latest()
                ->take(5)
                ->get();
        }

        return view('dashboard', compact(
            'totalProgramAktif',
            'totalKegiatanAktif',
            'totalTask',
            'taskSelesai',
            'taskOnProgress',
            'taskOverdue',
            'scrumHariIni',
            'taskSaya',
            'totalPegawaiAktif',
            'aktivitasPegawai',
            'pegawaiOptions',
            'selectedPegawai',
            'programMonitor',
            'scrumTerbaru',
            'selectedPegawaiTasks',
            'canViewAllTasks',
        ));
    }
}
