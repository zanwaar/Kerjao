@extends('layouts.app')
@section('title', 'Pegawai')
@section('content')

<x-page-header title="Daftar Pegawai" action-label="Tambah Pegawai" action-route="{{ route('pegawai.create') }}" />

<div class="bg-white rounded-xl border border-gray-200">
    {{-- Filter --}}
    <form method="GET" class="px-5 py-4 border-b border-gray-100 flex gap-3 flex-wrap">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / NIP..."
            class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 w-56">
        <select name="status" class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="">Semua Status</option>
            <option value="aktif" @selected(request('status') === 'aktif')>Aktif</option>
            <option value="nonaktif" @selected(request('status') === 'nonaktif')>Non-Aktif</option>
        </select>
        <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm px-4 py-1.5 rounded-lg">Filter</button>
        @if(request()->hasAny(['search', 'status']))
        <a href="{{ route('pegawai.index') }}" class="text-sm text-gray-500 hover:text-gray-700 self-center">Reset</a>
        @endif
    </form>

    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-5 py-3 font-medium text-gray-600">Nama</th>
                <th class="text-left px-5 py-3 font-medium text-gray-600">NIP</th>
                <th class="text-left px-5 py-3 font-medium text-gray-600">Jabatan</th>
                <th class="text-left px-5 py-3 font-medium text-gray-600">Unit Kerja</th>
                <th class="text-left px-5 py-3 font-medium text-gray-600">Status</th>
                <th class="px-5 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($pegawai as $p)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3">
                    <a href="{{ route('pegawai.show', $p) }}" class="font-medium text-gray-800 hover:text-indigo-600">{{ $p->nama_pegawai }}</a>
                    @if($p->user)
                    <p class="text-xs text-gray-400">{{ $p->user->email }}</p>
                    @endif
                </td>
                <td class="px-5 py-3 text-gray-600">{{ $p->nip ?? '-' }}</td>
                <td class="px-5 py-3 text-gray-600">{{ $p->jabatan }}</td>
                <td class="px-5 py-3 text-gray-600">{{ $p->unit_kerja }}</td>
                <td class="px-5 py-3">
                    <x-badge-status :status="$p->status_pegawai->value">{{ $p->status_pegawai->label() }}</x-badge-status>
                </td>
                <td class="px-5 py-3">
                    <div class="flex items-center gap-2 justify-end">
                        <a href="{{ route('pegawai.edit', $p) }}" class="text-gray-400 hover:text-indigo-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        @can('pegawai.delete')
                        <form method="POST" action="{{ route('pegawai.destroy', $p) }}" onsubmit="return confirm('Hapus pegawai ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                        @endcan
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-5 py-10 text-center text-gray-400">Tidak ada data pegawai</td></tr>
            @endforelse
        </tbody>
    </table>

    @if($pegawai->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">{{ $pegawai->links() }}</div>
    @endif
</div>
@endsection
