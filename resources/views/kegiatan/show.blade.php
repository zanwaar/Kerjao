@extends('layouts.app')
@section('title', $kegiatan->nama_kegiatan)
@section('content')

<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('kegiatan.index') }}" class="btn btn-sm btn-ghost-secondary me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M15 6l-6 6l6 6"/></svg>
                </a>
                <h3 class="card-title">Informasi Kegiatan</h3>
                @if(auth()->user()->can('kegiatan.edit') && $kegiatan->canBeManagedBy(auth()->user()))
                <div class="card-options">
                    <a href="{{ route('kegiatan.edit', $kegiatan) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                </div>
                @endif
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <x-badge-status :status="$kegiatan->status_kegiatan->value">{{ $kegiatan->status_kegiatan->label() }}</x-badge-status>
                </div>
                <dl class="row">
                    <dt class="col-5 text-secondary small">Program</dt>
                    <dd class="col-7 small">
                        <a href="{{ route('program-kerja.show', $kegiatan->programKerja) }}" class="text-primary">{{ $kegiatan->programKerja->nama_program }}</a>
                    </dd>
                    <dt class="col-5 text-secondary small">Mulai</dt>
                    <dd class="col-7 small">{{ $kegiatan->waktu_mulai->format('d M Y') }}</dd>
                    <dt class="col-5 text-secondary small">Selesai</dt>
                    <dd class="col-7 small">{{ $kegiatan->waktu_selesai->format('d M Y') }}</dd>
                    @if($kegiatan->target_capaian)
                    <dt class="col-5 text-secondary small">Target</dt>
                    <dd class="col-7 small">{{ $kegiatan->target_capaian }}</dd>
                    @endif
                </dl>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Task ({{ $kegiatan->tasks->count() }})</h3>
                @if(auth()->user()->can('task.create') && $kegiatan->canBeManagedBy(auth()->user()))
                <div class="card-options">
                    <a href="{{ route('task.create', ['kegiatan_id' => $kegiatan->id]) }}" class="btn btn-sm btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M12 5l0 14"/><path d="M5 12l14 0"/></svg>
                        Tambah Task
                    </a>
                </div>
                @endif
            </div>

            <div class="list-group list-group-flush">
                @forelse($kegiatan->tasks as $task)
                <div class="list-group-item">
                    <div class="d-flex align-items-center justify-content-between gap-2">
                        <div>
                            <a href="{{ route('task.show', $task) }}" class="fw-medium text-body">{{ $task->nama_task }}</a>
                            <div class="text-secondary small mt-1">
                                {{ $task->assignee->nama_pegawai }} · Due {{ $task->due_date?->format('d M Y') ?? '-' }}
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2 flex-shrink-0">
                            <span class="text-secondary small">{{ $task->progress_persen }}%</span>
                            <x-badge-status :status="$task->status->value">{{ $task->status->label() }}</x-badge-status>
                        </div>
                    </div>
                </div>
                @empty
                <div class="list-group-item text-center text-secondary py-5">Belum ada task</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
