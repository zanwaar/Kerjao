@extends('layouts.app')
@section('title', 'Task Saya')
@section('content')

@can('task.create')
<x-page-header title="Task Saya" action-label="Tambah Task" action-route="{{ route('task.create') }}" />
@endcan

@if(!$pegawai)
<div class="alert alert-warning">
    Akun Anda belum terhubung ke data pegawai. Hubungi admin untuk menghubungkan.
</div>
@else

<div class="card">
    <div class="card-header">
        <form method="GET" class="d-flex gap-2 flex-wrap w-100">
            <select name="program_kerja_id" class="form-select form-select-sm w-auto">
                <option value="">Semua Program</option>
                @foreach($programs as $program)
                <option value="{{ $program->id }}" @selected((string) request('program_kerja_id') === (string) $program->id)>{{ $program->nama_program }}</option>
                @endforeach
            </select>
            <select name="status" class="form-select form-select-sm w-auto">
                <option value="">Semua Status</option>
                @foreach($statuses as $s)
                <option value="{{ $s->value }}" @selected(request('status') === $s->value)>{{ $s->label() }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-sm btn-outline-secondary">Filter</button>
            @if(request()->hasAny(['program_kerja_id', 'status']))
            <a href="{{ route('task.saya') }}" class="btn btn-sm btn-ghost-secondary">Reset</a>
            @endif
        </form>
    </div>

    <div class="list-group list-group-flush">
        @forelse($tasks as $task)
        <div class="list-group-item">
            <div class="d-flex align-items-start justify-content-between gap-3">
                <div class="flex-grow-1 min-width-0">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <a href="{{ route('task.show', $task) }}" class="fw-medium text-body">{{ $task->nama_task }}</a>
                        <x-badge-status :status="$task->prioritas->value">{{ $task->prioritas->label() }}</x-badge-status>
                        <x-badge-status :status="$task->status->value">{{ $task->status->label() }}</x-badge-status>
                        @if(auth()->user()->can('task.edit') && $task->canBeUpdatedBy(auth()->user()))
                        <a href="{{ route('task.edit', $task) }}" class="small text-primary">Edit Progress</a>
                        @endif
                    </div>
                    <div class="text-secondary small mt-1">{{ $task->kegiatan->programKerja->nama_program }} · {{ $task->kegiatan->nama_kegiatan }}</div>
                    @if($task->due_date)
                    <div class="small mt-1 {{ $task->due_date->isPast() && $task->status->value !== 'done' ? 'text-danger fw-medium' : 'text-secondary' }}">
                        Due: {{ $task->due_date->format('d M Y') }}
                    </div>
                    @endif
                    <div class="progress progress-sm mt-2">
                        <div class="progress-bar bg-primary" style="width: {{ $task->progress_persen }}%"></div>
                    </div>
                </div>
                <div class="text-end flex-shrink-0">
                    <div class="h2 mb-1 text-primary">{{ $task->progress_persen }}<span class="text-secondary fs-5">%</span></div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('daily-scrum.create') }}?task_id={{ $task->id }}" class="small text-primary">+ Scrum</a>
                        <a href="{{ route('bukti-aktivitas.create') }}?task_id={{ $task->id }}" class="small text-secondary">+ Bukti</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="list-group-item text-center text-secondary py-5">Tidak ada task yang di-assign ke Anda</div>
        @endforelse
    </div>

    @if($tasks->hasPages())
    <div class="card-footer d-flex align-items-center">
        {{ $tasks->links() }}
    </div>
    @endif
</div>
@endif
@endsection
