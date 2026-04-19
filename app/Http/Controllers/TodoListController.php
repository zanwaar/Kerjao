<?php

namespace App\Http\Controllers;

use App\Enums\PrioritasTask;
use App\Enums\StatusTask;
use App\Http\Requests\StoreTodoListRequest;
use App\Models\Kegiatan;
use App\Models\Pegawai;
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
            ->when($request->kegiatan_id, fn ($q) => $q->where('kegiatan_id', $request->kegiatan_id))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $statuses = StatusTask::cases();
        $priorities = PrioritasTask::cases();
        $kegiatan = Kegiatan::visibleTo($user)->orderBy('nama_kegiatan')->get();

        return view('task.index', compact('tasks', 'statuses', 'priorities', 'kegiatan'));
    }

    public function saya(Request $request): View
    {
        $this->authorizePermission('task.view');

        $pegawai = $request->user()->pegawai;

        $tasks = TodoList::with(['kegiatan.programKerja'])
            ->when($pegawai, fn ($q) => $q->assignedTo($pegawai->id))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $statuses = StatusTask::cases();

        return view('task.saya', compact('tasks', 'statuses', 'pegawai'));
    }

    public function create(Request $request): View
    {
        $this->authorizePermission('task.create');

        $kegiatan = Kegiatan::with('programKerja')->orderBy('nama_kegiatan')->get();
        $pegawai = Pegawai::where('status_pegawai', 'aktif')->orderBy('nama_pegawai')->get();
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

    public function edit(TodoList $task): View
    {
        $this->authorizePermission('task.edit');

        $kegiatan = Kegiatan::with('programKerja')->orderBy('nama_kegiatan')->get();
        $pegawai = Pegawai::where('status_pegawai', 'aktif')->orderBy('nama_pegawai')->get();
        $statuses = StatusTask::cases();
        $priorities = PrioritasTask::cases();

        return view('task.edit', compact('task', 'kegiatan', 'pegawai', 'statuses', 'priorities'));
    }

    public function update(StoreTodoListRequest $request, TodoList $task): RedirectResponse
    {
        $task->update($request->validated());

        return redirect()->route('task.show', $task)->with('success', 'Task berhasil diperbarui.');
    }

    public function destroy(TodoList $task): RedirectResponse
    {
        $this->authorizePermission('task.delete');

        $task->delete();

        return redirect()->route('task.index')->with('success', 'Task berhasil dihapus.');
    }

    private function authorizePermission(string $permission): void
    {
        abort_unless(auth()->user()?->can($permission), 403);
    }
}
