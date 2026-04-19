<?php

namespace App\Http\Controllers;

use App\Enums\StatusProgram;
use App\Http\Requests\StoreProgramKerjaRequest;
use App\Models\ProgramKerja;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProgramKerjaController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorizePermission('program-kerja.view');

        $user = $request->user();

        $programs = ProgramKerja::with('creator')
            ->visibleTo($user)
            ->withCount(['kegiatan as kegiatan_count' => fn ($query) => $query->visibleTo($user)])
            ->when($request->search, fn ($q) => $q->where('nama_program', 'like', "%{$request->search}%"))
            ->when($request->status, fn ($q) => $q->where('status_program', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $statuses = StatusProgram::cases();

        return view('program-kerja.index', compact('programs', 'statuses'));
    }

    public function create(): View
    {
        $this->authorizePermission('program-kerja.create');

        $statuses = StatusProgram::cases();

        return view('program-kerja.create', compact('statuses'));
    }

    public function store(StoreProgramKerjaRequest $request): RedirectResponse
    {
        ProgramKerja::create([
            ...$request->validated(),
            'created_by' => $request->user()->id,
        ]);

        return redirect()->route('program-kerja.index')->with('success', 'Program kerja berhasil dibuat.');
    }

    public function show(Request $request, ProgramKerja $programKerja): View
    {
        $this->authorizePermission('program-kerja.view');

        $user = $request->user();

        $programKerja = ProgramKerja::query()
            ->visibleTo($user)
            ->whereKey($programKerja->getKey())
            ->firstOrFail();

        $programKerja->load([
            'creator',
            'kegiatan' => fn ($query) => $query
                ->visibleTo($user)
                ->withCount([
                    'tasks as tasks_count' => fn ($taskQuery) => $taskQuery->visibleTo($user),
                    'tasks as task_done_count' => fn ($taskQuery) => $taskQuery
                        ->visibleTo($user)
                        ->where('status', 'done'),
                ])
                ->with([
                    'tasks' => fn ($taskQuery) => $taskQuery
                        ->visibleTo($user)
                        ->withCount('dailyScrums')
                        ->with([
                            'assignee',
                            'dailyScrums' => fn ($scrumQuery) => $scrumQuery
                                ->with('pegawai')
                                ->latest('tanggal')
                                ->latest('id')
                                ->take(3),
                        ])
                        ->latest(),
                ]),
        ]);

        return view('program-kerja.show', compact('programKerja'));
    }

    public function edit(Request $request, ProgramKerja $programKerja): View
    {
        $this->authorizePermission('program-kerja.edit');
        abort_unless($programKerja->canBeManagedBy($request->user()), 403);

        $statuses = StatusProgram::cases();

        return view('program-kerja.edit', compact('programKerja', 'statuses'));
    }

    public function update(StoreProgramKerjaRequest $request, ProgramKerja $programKerja): RedirectResponse
    {
        abort_unless($programKerja->canBeManagedBy($request->user()), 403);

        $programKerja->update($request->validated());

        return redirect()->route('program-kerja.index')->with('success', 'Program kerja berhasil diperbarui.');
    }

    public function destroy(Request $request, ProgramKerja $programKerja): RedirectResponse
    {
        $this->authorizePermission('program-kerja.delete');
        abort_unless($programKerja->canBeManagedBy($request->user()), 403);

        $programKerja->delete();

        return redirect()->route('program-kerja.index')->with('success', 'Program kerja berhasil dihapus.');
    }

    private function authorizePermission(string $permission): void
    {
        abort_unless(auth()->user()?->can($permission), 403);
    }
}
