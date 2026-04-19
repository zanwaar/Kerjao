@extends('layouts.app')
@section('title', 'Daily Scrum')
@section('content')

@can('daily-scrum.create')
<x-page-header title="Daily Scrum" action-label="Tambah Scrum" action-route="{{ route('daily-scrum.create') }}" />
@else
<x-page-header title="Daily Scrum" />
@endcan

<div class="bg-white rounded-xl border border-gray-200">
    <form method="GET" class="px-5 py-4 border-b border-gray-100 flex gap-3 flex-wrap">
        @can('daily-scrum.view-all')
        <select name="pegawai_id" class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="">Semua Pegawai</option>
            @foreach($pegawaiList as $p)
            <option value="{{ $p->id }}" @selected(request('pegawai_id') == $p->id)>{{ $p->nama_pegawai }}</option>
            @endforeach
        </select>
        @endcan
        <input type="date" name="tanggal" value="{{ request('tanggal') }}"
            class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm px-4 py-1.5 rounded-lg">Filter</button>
    </form>

    <div class="divide-y divide-gray-50">
        @forelse($scrums as $scrum)
        <div class="px-5 py-4 hover:bg-gray-50">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-xs font-semibold text-gray-500">{{ $scrum->tanggal->format('d M Y') }}</span>
                        <span class="text-gray-300">·</span>
                        <span class="text-sm font-medium text-gray-800">{{ $scrum->pegawai->nama_pegawai }}</span>
                    </div>
                    <a href="{{ route('task.show', $scrum->task) }}" class="text-sm text-indigo-600 hover:underline mt-0.5 block">{{ $scrum->task->nama_task }}</a>
                    <p class="text-sm text-gray-600 mt-1">{{ Str::limit($scrum->rencana_kerja_harian, 120) }}</p>
                    @if($scrum->realisasi)
                    <p class="text-xs text-gray-400 mt-1"><span class="font-medium">Realisasi:</span> {{ Str::limit($scrum->realisasi, 80) }}</p>
                    @endif
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <a href="{{ route('daily-scrum.show', $scrum) }}" class="text-gray-400 hover:text-indigo-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </a>
                    <a href="{{ route('daily-scrum.edit', $scrum) }}" class="text-gray-400 hover:text-indigo-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="px-5 py-10 text-center text-gray-400">Tidak ada daily scrum</div>
        @endforelse
    </div>
    @if($scrums->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">{{ $scrums->links() }}</div>
    @endif
</div>
@endsection
