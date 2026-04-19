<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGithubActivityRequest;
use App\Models\GithubActivity;
use App\Models\Pegawai;
use App\Models\TodoList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GithubActivityController extends Controller
{
    public function index(Request $request): View
    {
        $activities = GithubActivity::with(['task.kegiatan', 'pegawai'])
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

        return view('github-activity.index', compact('activities'));
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

        return view('github-activity.create', compact('pegawaiList', 'pegawaiUser', 'tasks', 'selectedTask'));
    }

    public function store(StoreGithubActivityRequest $request): RedirectResponse
    {
        GithubActivity::create($request->validated());

        return redirect()->route('github-activity.index')->with('success', 'GitHub activity berhasil disimpan.');
    }

    public function edit(GithubActivity $githubActivity): View
    {
        $pegawaiList = Pegawai::where('status_pegawai', 'aktif')->orderBy('nama_pegawai')->get();
        $tasks = TodoList::with('kegiatan')->orderBy('nama_task')->get();

        return view('github-activity.edit', compact('githubActivity', 'pegawaiList', 'tasks'));
    }

    public function update(StoreGithubActivityRequest $request, GithubActivity $githubActivity): RedirectResponse
    {
        $githubActivity->update($request->validated());

        return redirect()->route('github-activity.index')->with('success', 'GitHub activity berhasil diperbarui.');
    }

    public function destroy(GithubActivity $githubActivity): RedirectResponse
    {
        $githubActivity->delete();

        return redirect()->route('github-activity.index')->with('success', 'GitHub activity berhasil dihapus.');
    }
}
