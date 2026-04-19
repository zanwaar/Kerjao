@extends('layouts.app')
@section('title', $programKerja->nama_program)
@section('content')

<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('program-kerja.index') }}" class="btn btn-sm btn-ghost-secondary me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M15 6l-6 6l6 6"/></svg>
                </a>
                <h3 class="card-title">Informasi Program</h3>
                @if(auth()->user()->can('program-kerja.edit') && $programKerja->canBeManagedBy(auth()->user()))
                <div class="card-options">
                    <a href="{{ route('program-kerja.edit', $programKerja) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                </div>
                @endif
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <x-badge-status :status="$programKerja->status_program->value">{{ $programKerja->status_program->label() }}</x-badge-status>
                </div>
                <dl class="row">
                    <dt class="col-5 text-secondary small">Mulai</dt>
                    <dd class="col-7 small">{{ $programKerja->waktu_mulai->format('d M Y') }}</dd>
                    <dt class="col-5 text-secondary small">Selesai</dt>
                    <dd class="col-7 small">{{ $programKerja->waktu_selesai->format('d M Y') }}</dd>
                    <dt class="col-5 text-secondary small">Dibuat oleh</dt>
                    <dd class="col-7 small">{{ $programKerja->creator->name }}</dd>
                    @if($programKerja->deskripsi)
                    <dt class="col-5 text-secondary small">Deskripsi</dt>
                    <dd class="col-7 small">{{ $programKerja->deskripsi }}</dd>
                    @endif
                </dl>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Kegiatan ({{ $programKerja->kegiatan->count() }})</h3>
                @if(auth()->user()->can('kegiatan.create') && $programKerja->canBeManagedBy(auth()->user()))
                <div class="card-options">
                    <a href="{{ route('kegiatan.create', ['program_kerja_id' => $programKerja->id]) }}" class="btn btn-sm btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M12 5l0 14"/><path d="M5 12l14 0"/></svg>
                        Tambah
                    </a>
                </div>
                @endif
            </div>

            <div class="list-group list-group-flush">
                @forelse($programKerja->kegiatan as $kegiatan)
                <div class="list-group-item">
                    <div class="d-flex align-items-start justify-content-between gap-2">
                        <div>
                            <a href="{{ route('kegiatan.show', $kegiatan) }}" class="fw-medium text-body">{{ $kegiatan->nama_kegiatan }}</a>
                            <div class="text-secondary small mt-1">
                                {{ $kegiatan->waktu_mulai->format('d M') }} — {{ $kegiatan->waktu_selesai->format('d M Y') }}
                                · {{ $kegiatan->task_done_count }}/{{ $kegiatan->tasks_count }} task selesai
                            </div>
                        </div>
                        <x-badge-status :status="$kegiatan->status_kegiatan->value">{{ $kegiatan->status_kegiatan->label() }}</x-badge-status>
                    </div>

                    @if(auth()->user()->can('task.view-all'))
                    <div class="mt-3 d-flex flex-column gap-2">
                        @forelse($kegiatan->tasks as $task)
                        <div class="card card-sm bg-light border-0">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between gap-2">
                                    <div class="min-width-0">
                                        <a href="{{ route('task.show', $task) }}" class="fw-medium text-body">{{ $task->nama_task }}</a>
                                        <div class="text-secondary small mt-1">{{ $task->assignee?->nama_pegawai ?? 'Belum diassign' }} · Progress {{ $task->progress_persen }}%</div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                        <span class="text-secondary small">{{ $task->daily_scrums_count }} scrum</span>
                                        <x-badge-status :status="$task->status->value">{{ $task->status->label() }}</x-badge-status>
                                    </div>
                                </div>
                                <div class="progress progress-sm mt-2">
                                    <div class="progress-bar bg-primary" style="width: {{ $task->progress_persen }}%"></div>
                                </div>

                                <div class="mt-2 d-flex flex-column gap-1">
                                    @forelse($task->dailyScrums as $scrum)
                                    <div class="card card-sm border">
                                        <div class="card-body p-2">
                                            <div class="d-flex justify-content-between">
                                                <span class="text-secondary small fw-medium">{{ $scrum->pegawai->nama_pegawai }}</span>
                                                <span class="text-secondary small">{{ $scrum->tanggal->format('d M Y') }}</span>
                                            </div>
                                            <p class="small text-body mt-1 mb-0">{{ $scrum->rencana_kerja_harian }}</p>
                                        </div>
                                    </div>
                                    @empty
                                    <p class="text-secondary small mb-0">Belum ada daily scrum pada task ini.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center text-secondary small py-3">Belum ada task pada kegiatan ini.</div>
                        @endforelse
                    </div>
                    @endif
                </div>
                @empty
                <div class="list-group-item text-center text-secondary py-5">Belum ada kegiatan</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
