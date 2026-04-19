<?php

namespace App\Http\Controllers;

use App\Enums\PrioritasTask;
use App\Enums\StatusTask;
use App\Http\Requests\StoreTodoListRequest;
use App\Models\Kegiatan;
use App\Models\Pegawai;
use App\Models\ProgramKerja;
use App\Models\TodoList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TodoListController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorizePermission('task.view');

        $user = $request->user();

        $tasks = TodoList::with(['kegiatan.programKerja', 'assignee', 'creator'])
            ->visibleTo($user)
            ->when($request->search, fn ($q) => $q->where('nama_task', 'like', "%{$request->search}%"))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->prioritas, fn ($q) => $q->where('prioritas', $request->prioritas))
            ->when($request->program_kerja_id, fn ($q) => $q->whereRelation('kegiatan', 'program_kerja_id', $request->program_kerja_id))
            ->when($request->kegiatan_id, fn ($q) => $q->where('kegiatan_id', $request->kegiatan_id))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $statuses = StatusTask::cases();
        $priorities = PrioritasTask::cases();
        $programs = ProgramKerja::visibleTo($user)->orderBy('nama_program')->get();
        $kegiatan = Kegiatan::visibleTo($user)->orderBy('nama_kegiatan')->get();

        return view('task.index', compact('tasks', 'statuses', 'priorities', 'programs', 'kegiatan'));
    }

    public function saya(Request $request): View
    {
        $this->authorizePermission('task.view');

        $user = $request->user();
        $pegawai = $user->pegawai;

        $tasks = TodoList::with(['kegiatan.programKerja'])
            ->when($pegawai, fn ($q) => $q->assignedTo($pegawai->id))
            ->when($request->program_kerja_id, fn ($q) => $q->whereRelation('kegiatan', 'program_kerja_id', $request->program_kerja_id))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $statuses = StatusTask::cases();
        $programs = ProgramKerja::query()
            ->when(
                $pegawai,
                fn ($query) => $query->whereHas('kegiatan.tasks', fn ($taskQuery) => $taskQuery->assignedTo($pegawai->id)),
                fn ($query) => $query->whereRaw('1 = 0')
            )
            ->orderBy('nama_program')
            ->get();

        return view('task.saya', compact('tasks', 'statuses', 'pegawai', 'programs'));
    }

    public function create(Request $request): View
    {
        $this->authorizePermission('task.create');

        $user = $request->user();

        $kegiatan = Kegiatan::query()
            ->with('programKerja')
            ->when(! $user->can('task.view-all'), fn ($query) => $query->ownedBy($user))
            ->orderBy('nama_kegiatan')
            ->get();
        $pegawai = Pegawai::query()
            ->where('status_pegawai', 'aktif')
            ->when(! $user->can('task.view-all'), fn ($query) => $query->whereKey($user->pegawai?->id))
            ->orderBy('nama_pegawai')
            ->get();
        $statuses = StatusTask::cases();
        $priorities = PrioritasTask::cases();
        $selectedKegiatan = $request->kegiatan_id;

        return view('task.create', compact('kegiatan', 'pegawai', 'statuses', 'priorities', 'selectedKegiatan'));
    }

    public function store(StoreTodoListRequest $request): RedirectResponse
    {
        TodoList::create([
            ...$request->validated(),
            'created_by' => $request->user()->id,
        ]);

        return redirect()->route('task.index')->with('success', 'Task berhasil dibuat.');
    }

    public function show(Request $request, TodoList $task): View
    {
        $this->authorizePermission('task.view');

        $task = TodoList::query()
            ->visibleTo($request->user())
            ->whereKey($task->getKey())
            ->firstOrFail();

        $task->load([
            'kegiatan.programKerja',
            'assignee',
            'creator',
            'dailyScrums' => fn ($q) => $q->with('pegawai')->latest(),
            'buktiAktivitas' => fn ($q) => $q->with('pegawai')->latest(),
            'githubActivities' => fn ($q) => $q->with('pegawai')->latest(),
            'wakatimeActivities' => fn ($q) => $q->with('pegawai')->latest(),
        ]);

        return view('task.show', compact('task'));
    }

    public function edit(Request $request, TodoList $task): View
    {
        $this->authorizePermission('task.edit');
        abort_unless($task->canBeUpdatedBy($request->user()), 403);

        $canManageTask = $task->canBeManagedBy($request->user());

        $kegiatan = $canManageTask
            ? Kegiatan::query()
                ->with('programKerja')
                ->when(! $request->user()->can('task.view-all'), fn ($query) => $query->ownedBy($request->user()))
                ->orderBy('nama_kegiatan')
                ->get()
            : collect();
        $pegawai = $canManageTask
            ? Pegawai::query()
                ->where('status_pegawai', 'aktif')
                ->when(! $request->user()->can('task.view-all'), fn ($query) => $query->whereKey($request->user()->pegawai?->id))
                ->orderBy('nama_pegawai')
                ->get()
            : collect();
        $statuses = StatusTask::cases();
        $priorities = PrioritasTask::cases();

        return view('task.edit', compact('task', 'kegiatan', 'pegawai', 'statuses', 'priorities', 'canManageTask'));
    }

    public function update(StoreTodoListRequest $request, TodoList $task): RedirectResponse
    {
        abort_unless($task->canBeUpdatedBy($request->user()), 403);

        $task->update($request->validated());

        return redirect()->route('task.show', $task)->with('success', 'Task berhasil diperbarui.');
    }

    public function destroy(Request $request, TodoList $task): RedirectResponse
    {
        $this->authorizePermission('task.delete');
        abort_unless($task->canBeManagedBy($request->user()), 403);

        $task->delete();

        return redirect()->route('task.index')->with('success', 'Task berhasil dihapus.');
    }

    private function authorizePermission(string $permission): void
    {
        abort_unless(auth()->user()?->can($permission), 403);
    }
}
