<?php

namespace App\Http\Controllers;

use App\Enums\StatusTask;
use App\Models\DailyScrum;
use App\Models\Kegiatan;
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

        $totalProgramAktif = ProgramKerja::query()
            ->visibleTo($user)
            ->where('status_program', 'active')
            ->count();

        $totalKegiatanAktif = Kegiatan::query()
            ->visibleTo($user)
            ->where('status_kegiatan', 'active')
            ->count();

        $visibleTasks = TodoList::query()->visibleTo($user);

        $totalTask = (clone $visibleTasks)->count();
        $taskSelesai = (clone $visibleTasks)->where('status', StatusTask::Done)->count();
        $taskOnProgress = (clone $visibleTasks)->where('status', StatusTask::OnProgress)->count();
        $taskOverdue = TodoList::query()
            ->visibleTo($user)
            ->overdue()
            ->with(['assignee', 'kegiatan.programKerja'])
            ->latest()
            ->take(10)
            ->get();

        $scrumHariIni = collect();
        $taskSaya = collect();

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
            'canViewAllTasks',
        ));
    }
}
