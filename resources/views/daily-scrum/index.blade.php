@extends('layouts.app')
@section('title', 'Daily Scrum')
@section('content')

@can('daily-scrum.create')
<x-page-header title="Daily Scrum" action-label="Tambah Scrum" action-route="{{ route('daily-scrum.create') }}" />
@endcan

<div class="card">
    <div class="card-header">
        <form method="GET" class="d-flex gap-2 flex-wrap w-100">
            @can('daily-scrum.view-all')
            <select name="pegawai_id" class="form-select form-select-sm w-auto">
                <option value="">Semua Pegawai</option>
                @foreach($pegawaiList as $p)
                <option value="{{ $p->id }}" @selected(request('pegawai_id') == $p->id)>{{ $p->nama_pegawai }}</option>
                @endforeach
            </select>
            @endcan
            <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control form-control-sm w-auto">
            <button type="submit" class="btn btn-sm btn-outline-secondary">Filter</button>
        </form>
    </div>

    <div class="list-group list-group-flush">
        @forelse($scrums as $scrum)
        <div class="list-group-item">
            <div class="d-flex align-items-start justify-content-between gap-3">
                <div class="flex-grow-1 min-width-0">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <span class="small fw-semibold text-secondary">{{ $scrum->tanggal->format('d M Y') }}</span>
                        <span class="text-secondary">·</span>
                        <span class="fw-medium">{{ $scrum->pegawai->nama_pegawai }}</span>
                    </div>
                    <a href="{{ route('task.show', $scrum->task) }}" class="text-primary small d-block mt-1">{{ $scrum->task->nama_task }}</a>
                    <p class="text-secondary mb-0 mt-1">{{ Str::limit($scrum->rencana_kerja_harian, 120) }}</p>
                    @if($scrum->realisasi)
                    <p class="text-secondary small mb-0 mt-1"><span class="fw-medium">Realisasi:</span> {{ Str::limit($scrum->realisasi, 80) }}</p>
                    @endif
                </div>
                <div class="d-flex gap-1 flex-shrink-0">
                    <a href="{{ route('daily-scrum.show', $scrum) }}" class="btn btn-sm btn-icon btn-ghost-secondary" title="Lihat">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/></svg>
                    </a>
                    <a href="{{ route('daily-scrum.edit', $scrum) }}" class="btn btn-sm btn-icon btn-ghost-secondary" title="Edit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/><path d="M16 5l3 3"/></svg>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="list-group-item text-center text-secondary py-5">Tidak ada daily scrum</div>
        @endforelse
    </div>

    @if($scrums->hasPages())
    <div class="card-footer d-flex align-items-center">
        {{ $scrums->links() }}
    </div>
    @endif
</div>
@endsection
