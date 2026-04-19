@extends('layouts.app')
@section('title', $task->nama_task)
@section('content')

<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('task.index') }}" class="btn btn-sm btn-ghost-secondary me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M15 6l-6 6l6 6"/></svg>
                </a>
                <h3 class="card-title">Detail Task</h3>
                @if(auth()->user()->can('task.edit') && $task->canBeUpdatedBy(auth()->user()))
                <div class="card-options">
                    <a href="{{ route('task.edit', $task) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                </div>
                @endif
            </div>
            <div class="card-body">
                <div class="d-flex gap-2 mb-3 flex-wrap">
                    <x-badge-status :status="$task->prioritas->value">{{ $task->prioritas->label() }}</x-badge-status>
                    <x-badge-status :status="$task->status->value">{{ $task->status->label() }}</x-badge-status>
                </div>
                <dl class="row">
                    <dt class="col-5 text-secondary small">Program</dt>
                    <dd class="col-7 small">{{ $task->kegiatan->programKerja->nama_program }}</dd>
                    <dt class="col-5 text-secondary small">Kegiatan</dt>
                    <dd class="col-7 small">
                        <a href="{{ route('kegiatan.show', $task->kegiatan) }}" class="text-primary">{{ $task->kegiatan->nama_kegiatan }}</a>
                    </dd>
                    <dt class="col-5 text-secondary small">Pelaksana</dt>
                    <dd class="col-7 small">{{ $task->assignee->nama_pegawai }}</dd>
                    <dt class="col-5 text-secondary small">Due Date</dt>
                    <dd class="col-7 small {{ $task->due_date && $task->due_date->isPast() && $task->status->value !== 'done' ? 'text-danger fw-medium' : '' }}">
                        {{ $task->due_date?->format('d M Y') ?? '-' }}
                    </dd>
                </dl>
                <div class="mt-2">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small text-secondary">Progress</span>
                        <span class="small fw-semibold">{{ $task->progress_persen }}%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-primary" style="width: {{ $task->progress_persen }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        @if($task->deskripsi_task)
        <div class="card mt-3">
            <div class="card-header"><h3 class="card-title">Deskripsi</h3></div>
            <div class="card-body">
                <p class="text-secondary mb-0">{{ $task->deskripsi_task }}</p>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-8">
        {{-- Daily Scrum --}}
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Daily Scrum ({{ $task->dailyScrums->count() }})</h3>
                @can('daily-scrum.create')
                <div class="card-options">
                    <a href="{{ route('daily-scrum.create') }}?task_id={{ $task->id }}" class="btn btn-sm btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M12 5l0 14"/><path d="M5 12l14 0"/></svg>
                        Tambah
                    </a>
                </div>
                @endcan
            </div>
            <div class="list-group list-group-flush">
                @forelse($task->dailyScrums->take(5) as $scrum)
                <div class="list-group-item">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-medium text-secondary">{{ $scrum->tanggal->format('d M Y') }}</span>
                        <span class="small text-secondary">{{ $scrum->pegawai->nama_pegawai }}</span>
                    </div>
                    <p class="text-body mb-0">{{ $scrum->rencana_kerja_harian }}</p>
                    @if($scrum->realisasi)
                    <p class="small text-secondary mt-1 mb-0">Realisasi: {{ $scrum->realisasi }}</p>
                    @endif
                </div>
                @empty
                <div class="list-group-item text-center text-secondary py-4">Belum ada daily scrum</div>
                @endforelse
            </div>
        </div>

        {{-- Bukti Aktivitas --}}
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Bukti Aktivitas ({{ $task->buktiAktivitas->count() }})</h3>
                @can('bukti-aktivitas.create')
                <div class="card-options">
                    <a href="{{ route('bukti-aktivitas.create') }}?task_id={{ $task->id }}" class="btn btn-sm btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M12 5l0 14"/><path d="M5 12l14 0"/></svg>
                        Tambah
                    </a>
                </div>
                @endcan
            </div>
            <div class="list-group list-group-flush">
                @forelse($task->buktiAktivitas as $bukti)
                <div class="list-group-item d-flex align-items-center gap-3">
                    <x-badge-status :status="'planning'">{{ $bukti->jenis_bukti->label() }}</x-badge-status>
                    @if($bukti->jenis_bukti->value === 'link')
                    <a href="{{ $bukti->sumber_bukti }}" target="_blank" class="text-primary text-truncate">{{ $bukti->sumber_bukti }}</a>
                    @else
                    <span class="text-body text-truncate">{{ $bukti->sumber_bukti }}</span>
                    @endif
                </div>
                @empty
                <div class="list-group-item text-center text-secondary py-4">Belum ada bukti aktivitas</div>
                @endforelse
            </div>
        </div>

        {{-- GitHub --}}
        @if($task->githubActivities->isNotEmpty())
        <div class="card">
            <div class="card-header"><h3 class="card-title">GitHub Activity ({{ $task->githubActivities->count() }})</h3></div>
            <div class="list-group list-group-flush">
                @foreach($task->githubActivities as $gh)
                <div class="list-group-item">
                    <p class="fw-medium mb-0">{{ $gh->repo_name }} @if($gh->branch_name)<span class="text-secondary fw-normal">/ {{ $gh->branch_name }}</span>@endif</p>
                    @if($gh->commit_message)<p class="text-secondary small mb-0 text-truncate">{{ $gh->commit_message }}</p>@endif
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
