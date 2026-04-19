<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWakatimeActivityRequest;
use App\Models\Pegawai;
use App\Models\TodoList;
use App\Models\WakatimeActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WakatimeActivityController extends Controller
{
    public function index(Request $request): View
    {
        $activities = WakatimeActivity::with(['task.kegiatan', 'pegawai'])
            ->when($request->pegawai_id, fn ($q) => $q->where('pegawai_id', $request->pegawai_id))
            ->when(! $request->user()->can('task.view-all'), function ($q) use ($request) {
                $pegawai = $request->user()->pegawai;
                if ($pegawai) {
                    $q->where('pegawai_id', $pegawai->id);
                }
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('wakatime-activity.index', compact('activities'));
    }

    public function create(Request $request): View
    {
        $pegawaiList = Pegawai::where('status_pegawai', 'aktif')->orderBy('nama_pegawai')->get();
        $pegawaiUser = $request->user()->pegawai;

        $tasks = TodoList::with('kegiatan')
            ->when($pegawaiUser && ! $request->user()->can('task.view-all'),
                fn ($q) => $q->where('assigned_to', $pegawaiUser->id))
            ->orderBy('nama_task')
            ->get();

        $selectedTask = $request->task_id;

        return view('wakatime-activity.create', compact('pegawaiList', 'pegawaiUser', 'tasks', 'selectedTask'));
    }

    public function store(StoreWakatimeActivityRequest $request): RedirectResponse
    {
        WakatimeActivity::create($request->validated());

        return redirect()->route('wakatime-activity.index')->with('success', 'WakaTime activity berhasil disimpan.');
    }

    public function edit(WakatimeActivity $wakatimeActivity): View
    {
        $pegawaiList = Pegawai::where('status_pegawai', 'aktif')->orderBy('nama_pegawai')->get();
        $tasks = TodoList::with('kegiatan')->orderBy('nama_task')->get();

        return view('wakatime-activity.edit', compact('wakatimeActivity', 'pegawaiList', 'tasks'));
    }

    public function update(StoreWakatimeActivityRequest $request, WakatimeActivity $wakatimeActivity): RedirectResponse
    {
        $wakatimeActivity->update($request->validated());

        return redirect()->route('wakatime-activity.index')->with('success', 'WakaTime activity berhasil diperbarui.');
    }

    public function destroy(WakatimeActivity $wakatimeActivity): RedirectResponse
    {
        $wakatimeActivity->delete();

        return redirect()->route('wakatime-activity.index')->with('success', 'WakaTime activity berhasil dihapus.');
    }
}
