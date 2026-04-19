<?php

namespace App\Http\Controllers;

use App\Enums\StatusTask;
use App\Http\Requests\StorePegawaiRequest;
use App\Models\DailyScrum;
use App\Models\Pegawai;
use App\Models\ProgramKerja;
use App\Models\TodoList;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PegawaiController extends Controller
{
    public function index(Request $request): View
    {
        $pegawai = Pegawai::with('user')
            ->when($request->search, fn ($q) => $q->where('nama_pegawai', 'like', "%{$request->search}%")
                ->orWhere('nip', 'like', "%{$request->search}%"))
            ->when($request->status, fn ($q) => $q->where('status_pegawai', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('pegawai.index', compact('pegawai'));
    }

    public function create(): View
    {
        $users = User::doesntHave('pegawai')->orderBy('name')->get();

        return view('pegawai.create', compact('users'));
    }

    public function store(StorePegawaiRequest $request): RedirectResponse
    {
        Pegawai::create($request->validated());

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan.');
    }

    public function show(Pegawai $pegawai): View
    {
        $pegawai->load('user');

        $tasks = TodoList::query()
            ->assignedTo($pegawai->id)
            ->withCount('dailyScrums')
            ->with([
                'kegiatan.programKerja',
                'dailyScrums' => fn ($query) => $query
                    ->with('pegawai')
                    ->latest('tanggal')
                    ->latest('id')
                    ->take(3),
            ])
            ->latest()
            ->get();

        $programs = ProgramKerja::query()
            ->whereHas('kegiatan.tasks', fn ($query) => $query->assignedTo($pegawai->id))
            ->with([
                'kegiatan' => fn ($query) => $query
                    ->whereHas('tasks', fn ($taskQuery) => $taskQuery->assignedTo($pegawai->id))
                    ->withCount([
                        'tasks as tasks_count' => fn ($taskQuery) => $taskQuery->assignedTo($pegawai->id),
                        'tasks as task_done_count' => fn ($taskQuery) => $taskQuery
                            ->assignedTo($pegawai->id)
                            ->where('status', 'done'),
                    ]),
            ])
            ->orderBy('nama_program')
            ->get();

        $dailyScrums = DailyScrum::query()
            ->where('pegawai_id', $pegawai->id)
            ->with('task.kegiatan.programKerja')
            ->latest('tanggal')
            ->latest('id')
            ->take(10)
            ->get();

        $summary = [
            'program_count' => $programs->count(),
            'task_count' => $tasks->count(),
            'task_done_count' => $tasks->where('status', StatusTask::Done)->count(),
            'daily_scrum_count' => $dailyScrums->count(),
        ];

        return view('pegawai.show', compact('pegawai', 'tasks', 'programs', 'dailyScrums', 'summary'));
    }

    public function edit(Pegawai $pegawai): View
    {
        $users = User::doesntHave('pegawai')
            ->orWhere('id', $pegawai->user_id)
            ->orderBy('name')
            ->get();

        return view('pegawai.edit', compact('pegawai', 'users'));
    }

    public function update(StorePegawaiRequest $request, Pegawai $pegawai): RedirectResponse
    {
        $pegawai->update($request->validated());

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy(Pegawai $pegawai): RedirectResponse
    {
        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus.');
    }
}
