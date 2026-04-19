@extends('layouts.app')
@section('title', 'Program Kerja')
@section('content')

@can('program-kerja.create')
<x-page-header title="Program Kerja" action-label="Tambah Program" action-route="{{ route('program-kerja.create') }}" />
@else
<x-page-header title="Program Kerja" />
@endcan

<div class="bg-white rounded-xl border border-gray-200">
    <form method="GET" class="px-5 py-4 border-b border-gray-100 flex gap-3 flex-wrap">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama program..."
            class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 w-56">
        <select name="status" class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="">Semua Status</option>
            @foreach($statuses as $s)
            <option value="{{ $s->value }}" @selected(request('status') === $s->value)>{{ $s->label() }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm px-4 py-1.5 rounded-lg">Filter</button>
        @if(request()->hasAny(['search', 'status']))
        <a href="{{ route('program-kerja.index') }}" class="text-sm text-gray-500 self-center">Reset</a>
        @endif
    </form>

    <div class="divide-y divide-gray-50">
        @forelse($programs as $program)
        <div class="px-5 py-4 hover:bg-gray-50 flex items-start justify-between gap-4">
            <div class="min-w-0 flex-1">
                <div class="flex items-center gap-2 flex-wrap">
                    <a href="{{ route('program-kerja.show', $program) }}" class="font-medium text-gray-800 hover:text-indigo-600">{{ $program->nama_program }}</a>
                    <x-badge-status :status="$program->status_program->value">{{ $program->status_program->label() }}</x-badge-status>
                </div>
                <p class="text-xs text-gray-400 mt-1">
                    {{ $program->waktu_mulai->format('d M Y') }} — {{ $program->waktu_selesai->format('d M Y') }}
                    · {{ $program->kegiatan_count }} kegiatan
                    · Oleh {{ $program->creator->name }}
                </p>
                @if($program->deskripsi)
                <p class="text-sm text-gray-500 mt-1 line-clamp-1">{{ $program->deskripsi }}</p>
                @endif
            </div>
            @can('program-kerja.edit')
            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('program-kerja.edit', $program) }}" class="text-gray-400 hover:text-indigo-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </a>
                @can('program-kerja.delete')
                <form method="POST" action="{{ route('program-kerja.destroy', $program) }}" onsubmit="return confirm('Hapus program ini? Semua kegiatan terkait akan ikut terhapus.')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-gray-400 hover:text-red-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </form>
                @endcan
            </div>
            @endcan
        </div>
        @empty
        <div class="px-5 py-10 text-center text-gray-400">Belum ada program kerja</div>
        @endforelse
    </div>

    @if($programs->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">{{ $programs->links() }}</div>
    @endif
</div>
@endsection
