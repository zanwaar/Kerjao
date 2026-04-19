<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDailyScrumRequest;
use App\Models\DailyScrum;
use App\Models\Pegawai;
use App\Models\TodoList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DailyScrumController extends Controller
{
    public function index(Request $request): View
    {
        $scrums = DailyScrum::with(['pegawai', 'task.kegiatan'])
            ->when($request->pegawai_id, fn ($q) => $q->where('pegawai_id', $request->pegawai_id))
            ->when($request->tanggal, fn ($q) => $q->whereDate('tanggal', $request->tanggal))
            ->when(! $request->user()->can('daily-scrum.view-all'), function ($q) use ($request) {
                $pegawai = $request->user()->pegawai;
                if ($pegawai) {
                    $q->where('pegawai_id', $pegawai->id);
                }
            })
            ->latest('tanggal')
            ->paginate(15)
            ->withQueryString();

        $pegawaiList = Pegawai::orderBy('nama_pegawai')->get();

        return view('daily-scrum.index', compact('scrums', 'pegawaiList'));
    }

    public function create(Request $request): View
    {
        $pegawaiList = Pegawai::where('status_pegawai', 'aktif')->orderBy('nama_pegawai')->get();
        $pegawaiUser = $request->user()->pegawai;

        $tasks = TodoList::with('kegiatan')
            ->when($pegawaiUser && ! $request->user()->can('daily-scrum.view-all'),
                fn ($q) => $q->where('assigned_to', $pegawaiUser->id))
            ->whereNotIn('status', ['done', 'canceled'])
            ->orderBy('nama_task')
            ->get();

        return view('daily-scrum.create', compact('pegawaiList', 'tasks', 'pegawaiUser'));
    }

    public function store(StoreDailyScrumRequest $request): RedirectResponse
    {
        DailyScrum::create($request->validated());

        return redirect()->route('daily-scrum.index')->with('success', 'Daily scrum berhasil disimpan.');
    }

    public function show(DailyScrum $dailyScrum): View
    {
        $dailyScrum->load(['pegawai', 'task.kegiatan.programKerja']);

        return view('daily-scrum.show', compact('dailyScrum'));
    }

    public function edit(DailyScrum $dailyScrum): View
    {
        $pegawaiList = Pegawai::where('status_pegawai', 'aktif')->orderBy('nama_pegawai')->get();
        $tasks = TodoList::with('kegiatan')->whereNotIn('status', ['canceled'])->orderBy('nama_task')->get();

        return view('daily-scrum.edit', compact('dailyScrum', 'pegawaiList', 'tasks'));
    }

    public function update(StoreDailyScrumRequest $request, DailyScrum $dailyScrum): RedirectResponse
    {
        $dailyScrum->update($request->validated());

        return redirect()->route('daily-scrum.index')->with('success', 'Daily scrum berhasil diperbarui.');
    }

    public function destroy(DailyScrum $dailyScrum): RedirectResponse
    {
        $dailyScrum->delete();

        return redirect()->route('daily-scrum.index')->with('success', 'Daily scrum berhasil dihapus.');
    }
}
