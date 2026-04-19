<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePegawaiRequest;
use App\Models\Pegawai;
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
        $pegawai->load(['user', 'tasks.kegiatan.programKerja', 'dailyScrums' => fn ($q) => $q->latest()->take(10)]);

        return view('pegawai.show', compact('pegawai'));
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
