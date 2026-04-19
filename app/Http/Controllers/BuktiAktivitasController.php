<?php

namespace App\Http\Controllers;

use App\Enums\JenisBukti;
use App\Http\Requests\StoreBuktiAktivitasRequest;
use App\Models\BuktiAktivitas;
use App\Models\Pegawai;
use App\Models\TodoList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BuktiAktivitasController extends Controller
{
    public function index(Request $request): View
    {
        $bukti = BuktiAktivitas::with(['task.kegiatan', 'pegawai'])
            ->when($request->pegawai_id, fn ($q) => $q->where('pegawai_id', $request->pegawai_id))
            ->when($request->task_id, fn ($q) => $q->where('task_id', $request->task_id))
            ->when(! $request->user()->can('task.view-all'), function ($q) use ($request) {
                $pegawai = $request->user()->pegawai;
                if ($pegawai) {
                    $q->where('pegawai_id', $pegawai->id);
                }
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('bukti-aktivitas.index', compact('bukti'));
    }

    public function create(Request $request): View
    {
        $pegawaiList = Pegawai::where('status_pegawai', 'aktif')->orderBy('nama_pegawai')->get();
        $pegawaiUser = $request->user()->pegawai;
        $jenisList = JenisBukti::cases();

        $tasks = TodoList::with('kegiatan')
            ->when($pegawaiUser && ! $request->user()->can('task.view-all'),
                fn ($q) => $q->where('assigned_to', $pegawaiUser->id))
            ->orderBy('nama_task')
            ->get();

        $selectedTask = $request->task_id;

        return view('bukti-aktivitas.create', compact('pegawaiList', 'pegawaiUser', 'jenisList', 'tasks', 'selectedTask'));
    }

    public function store(StoreBuktiAktivitasRequest $request): RedirectResponse
    {
        BuktiAktivitas::create($request->validated());

        return redirect()->route('bukti-aktivitas.index')->with('success', 'Bukti aktivitas berhasil disimpan.');
    }

    public function edit(BuktiAktivitas $buktiAktivita): View
    {
        $pegawaiList = Pegawai::where('status_pegawai', 'aktif')->orderBy('nama_pegawai')->get();
        $tasks = TodoList::with('kegiatan')->orderBy('nama_task')->get();
        $jenisList = JenisBukti::cases();

        return view('bukti-aktivitas.edit', compact('buktiAktivita', 'pegawaiList', 'tasks', 'jenisList'));
    }

    public function update(StoreBuktiAktivitasRequest $request, BuktiAktivitas $buktiAktivita): RedirectResponse
    {
        $buktiAktivita->update($request->validated());

        return redirect()->route('bukti-aktivitas.index')->with('success', 'Bukti aktivitas berhasil diperbarui.');
    }

    public function destroy(BuktiAktivitas $buktiAktivita): RedirectResponse
    {
        $buktiAktivita->delete();

        return redirect()->route('bukti-aktivitas.index')->with('success', 'Bukti aktivitas berhasil dihapus.');
    }
}
