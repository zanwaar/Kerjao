@extends('layouts.app')
@section('title', 'Pegawai')
@section('content')

<x-page-header title="Daftar Pegawai" action-label="Tambah Pegawai" action-route="{{ route('pegawai.create') }}" />

<div class="card">
    <div class="card-header">
        <form method="GET" class="d-flex gap-2 flex-wrap w-100">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / NIP..."
                class="form-control form-control-sm w-auto">
            <select name="status" class="form-select form-select-sm w-auto">
                <option value="">Semua Status</option>
                <option value="aktif" @selected(request('status') === 'aktif')>Aktif</option>
                <option value="nonaktif" @selected(request('status') === 'nonaktif')>Non-Aktif</option>
            </select>
            <button type="submit" class="btn btn-sm btn-outline-secondary">Filter</button>
            @if(request()->hasAny(['search', 'status']))
            <a href="{{ route('pegawai.index') }}" class="btn btn-sm btn-ghost-secondary">Reset</a>
            @endif
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-vcenter card-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>NIP</th>
                    <th>Jabatan</th>
                    <th>Unit Kerja</th>
                    <th>Status</th>
                    <th class="w-1"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($pegawai as $p)
                <tr>
                    <td>
                        <a href="{{ route('pegawai.show', $p) }}" class="fw-medium text-body">{{ $p->nama_pegawai }}</a>
                        @if($p->user)
                        <div class="text-secondary small">{{ $p->user->email }}</div>
                        @endif
                    </td>
                    <td class="text-secondary">{{ $p->nip ?? '-' }}</td>
                    <td class="text-secondary">{{ $p->jabatan }}</td>
                    <td class="text-secondary">{{ $p->unit_kerja }}</td>
                    <td>
                        <x-badge-status :status="$p->status_pegawai->value">{{ $p->status_pegawai->label() }}</x-badge-status>
                    </td>
                    <td>
                        <div class="d-flex gap-1 justify-content-end">
                            <a href="{{ route('pegawai.edit', $p) }}" class="btn btn-sm btn-icon btn-ghost-secondary" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/><path d="M16 5l3 3"/></svg>
                            </a>
                            @can('pegawai.delete')
                            <form method="POST" action="{{ route('pegawai.destroy', $p) }}" onsubmit="return confirm('Hapus pegawai ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-icon btn-ghost-danger" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M4 7l16 0"/><path d="M10 11l0 6"/><path d="M14 11l0 6"/><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/></svg>
                                </button>
                            </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-secondary py-5">Tidak ada data pegawai</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pegawai->hasPages())
    <div class="card-footer d-flex align-items-center">
        {{ $pegawai->links() }}
    </div>
    @endif
</div>
@endsection
