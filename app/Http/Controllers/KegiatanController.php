<?php

namespace App\Http\Controllers;

use App\Enums\StatusKegiatan;
use App\Http\Requests\StoreKegiatanRequest;
use App\Models\Kegiatan;
use App\Models\ProgramKerja;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KegiatanController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorizePermission('kegiatan.view');

        $user = $request->user();

        $kegiatan = Kegiatan::with(['programKerja', 'creator'])
            ->visibleTo($user)
            ->withCount(['tasks as tasks_count' => fn ($query) => $query->visibleTo($user)])
            ->when($request->search, fn ($q) => $q->where('nama_kegiatan', 'like', "%{$request->search}%"))
            ->when($request->program_kerja_id, fn ($q) => $q->where('program_kerja_id', $request->program_kerja_id))
            ->when($request->status, fn ($q) => $q->where('status_kegiatan', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $programs = ProgramKerja::visibleTo($user)->orderBy('nama_program')->get();
        $statuses = StatusKegiatan::cases();

        return view('kegiatan.index', compact('kegiatan', 'programs', 'statuses'));
    }

    public function create(Request $request): View
    {
        $this->authorizePermission('kegiatan.create');

        $programs = ProgramKerja::orderBy('nama_program')->get();
        $statuses = StatusKegiatan::cases();
        $selectedProgram = $request->program_kerja_id;

        return view('kegiatan.create', compact('programs', 'statuses', 'selectedProgram'));
    }

    public function store(StoreKegiatanRequest $request): RedirectResponse
    {
        Kegiatan::create([
            ...$request->validated(),
            'created_by' => $request->user()->id,
        ]);

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dibuat.');
    }

    public function show(Request $request, Kegiatan $kegiatan): View
    {
        $this->authorizePermission('kegiatan.view');

        $user = $request->user();

        $kegiatan = Kegiatan::query()
            ->visibleTo($user)
            ->whereKey($kegiatan->getKey())
            ->firstOrFail();

        $kegiatan->load([
            'programKerja',
            'creator',
            'tasks' => fn ($query) => $query->visibleTo($user)->with('assignee')->latest(),
        ]);

        return view('kegiatan.show', compact('kegiatan'));
    }

    public function edit(Kegiatan $kegiatan): View
    {
        $this->authorizePermission('kegiatan.edit');

        $programs = ProgramKerja::orderBy('nama_program')->get();
        $statuses = StatusKegiatan::cases();

        return view('kegiatan.edit', compact('kegiatan', 'programs', 'statuses'));
    }

    public function update(StoreKegiatanRequest $request, Kegiatan $kegiatan): RedirectResponse
    {
        $kegiatan->update($request->validated());

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Kegiatan $kegiatan): RedirectResponse
    {
        $this->authorizePermission('kegiatan.delete');

        $kegiatan->delete();

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dihapus.');
    }

    private function authorizePermission(string $permission): void
    {
        abort_unless(auth()->user()?->can($permission), 403);
    }
}
