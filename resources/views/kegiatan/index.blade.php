@extends('layouts.app')
@section('title', 'Kegiatan')
@section('content')

@can('kegiatan.create')
<x-page-header title="Kegiatan" action-label="Tambah Kegiatan" action-route="{{ route('kegiatan.create') }}" />
@else
<x-page-header title="Kegiatan" />
@endcan

<div class="bg-white rounded-xl border border-gray-200">
    <form method="GET" class="px-5 py-4 border-b border-gray-100 flex gap-3 flex-wrap">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kegiatan..."
            class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 w-48">
        <select name="program_kerja_id" class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="">Semua Program</option>
            @foreach($programs as $p)
            <option value="{{ $p->id }}" @selected(request('program_kerja_id') == $p->id)>{{ $p->nama_program }}</option>
            @endforeach
        </select>
        <select name="status" class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="">Semua Status</option>
            @foreach($statuses as $s)
            <option value="{{ $s->value }}" @selected(request('status') === $s->value)>{{ $s->label() }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm px-4 py-1.5 rounded-lg">Filter</button>
        @if(request()->hasAny(['search', 'status', 'program_kerja_id']))
        <a href="{{ route('kegiatan.index') }}" class="text-sm text-gray-500 self-center">Reset</a>
        @endif
    </form>

    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-5 py-3 font-medium text-gray-600">Kegiatan</th>
                <th class="text-left px-5 py-3 font-medium text-gray-600">Program</th>
                <th class="text-left px-5 py-3 font-medium text-gray-600">Periode</th>
                <th class="text-left px-5 py-3 font-medium text-gray-600">Task</th>
                <th class="text-left px-5 py-3 font-medium text-gray-600">Status</th>
                <th class="px-5 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($kegiatan as $k)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3">
                    <a href="{{ route('kegiatan.show', $k) }}" class="font-medium text-gray-800 hover:text-indigo-600">{{ $k->nama_kegiatan }}</a>
                </td>
                <td class="px-5 py-3 text-gray-500 text-xs">{{ $k->programKerja->nama_program }}</td>
                <td class="px-5 py-3 text-gray-500 text-xs whitespace-nowrap">{{ $k->waktu_mulai->format('d M Y') }}<br>{{ $k->waktu_selesai->format('d M Y') }}</td>
                <td class="px-5 py-3 text-gray-600">{{ $k->tasks_count }}</td>
                <td class="px-5 py-3"><x-badge-status :status="$k->status_kegiatan->value">{{ $k->status_kegiatan->label() }}</x-badge-status></td>
                <td class="px-5 py-3">
                    <div class="flex items-center gap-2 justify-end">
                        @if(auth()->user()->can('kegiatan.edit') && $k->canBeManagedBy(auth()->user()))
                        <a href="{{ route('kegiatan.edit', $k) }}" class="text-gray-400 hover:text-indigo-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        @endif
                        @if(auth()->user()->can('kegiatan.delete') && $k->canBeManagedBy(auth()->user()))
                        <form method="POST" action="{{ route('kegiatan.destroy', $k) }}" onsubmit="return confirm('Hapus kegiatan ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-5 py-10 text-center text-gray-400">Tidak ada data kegiatan</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($kegiatan->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">{{ $kegiatan->links() }}</div>
    @endif
</div>
@endsection
