@extends('layouts.app')
@section('title', $pegawai->nama_pegawai)
@section('content')

<div class="row">
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header">
                <a href="{{ route('pegawai.index') }}" class="btn btn-sm btn-ghost-secondary me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M15 6l-6 6l6 6"/></svg>
                </a>
                <h3 class="card-title">Informasi Pegawai</h3>
                @can('pegawai.edit')
                <div class="card-options">
                    <a href="{{ route('pegawai.edit', $pegawai) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                </div>
                @endcan
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <span class="avatar avatar-lg bg-primary-lt">{{ strtoupper(substr($pegawai->nama_pegawai, 0, 1)) }}</span>
                    <div>
                        <div class="fw-semibold">{{ $pegawai->nama_pegawai }}</div>
                        <x-badge-status :status="$pegawai->status_pegawai->value">{{ $pegawai->status_pegawai->label() }}</x-badge-status>
                    </div>
                </div>
                <dl class="row">
                    <dt class="col-5 text-secondary small">NIP</dt>
                    <dd class="col-7 fw-medium">{{ $pegawai->nip ?? '-' }}</dd>

                    <dt class="col-5 text-secondary small">Jabatan</dt>
                    <dd class="col-7">{{ $pegawai->jabatan }}</dd>

                    <dt class="col-5 text-secondary small">Unit Kerja</dt>
                    <dd class="col-7">{{ $pegawai->unit_kerja }}</dd>

                    @if($pegawai->user)
                    <dt class="col-5 text-secondary small">Email</dt>
                    <dd class="col-7">{{ $pegawai->user->email }}</dd>
                    @endif

                    @if($pegawai->github_username)
                    <dt class="col-5 text-secondary small">GitHub</dt>
                    <dd class="col-7 text-primary">@{{ $pegawai->github_username }}</dd>
                    @endif
                </dl>
            </div>
        </div>

        <div class="row row-cards mb-3">
            <div class="col-6">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="subheader">Program</div>
                        <div class="h1 mb-0 text-primary">{{ $summary['program_count'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="subheader">Total Task</div>
                        <div class="h1 mb-0 text-azure">{{ $summary['task_count'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="subheader">Selesai</div>
                        <div class="h1 mb-0 text-success">{{ $summary['task_done_count'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="subheader">Daily Scrum</div>
                        <div class="h1 mb-0 text-warning">{{ $summary['daily_scrum_count'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Program yang Dikerjakan</h3>
                <div class="card-options">
                    <span class="text-secondary small">{{ $programs->count() }} program</span>
                </div>
            </div>
            <div class="list-group list-group-flush">
                @forelse($programs as $program)
                <div class="list-group-item">
                    <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                        <a href="{{ route('program-kerja.show', $program) }}" class="fw-medium text-body">{{ $program->nama_program }}</a>
                        <x-badge-status :status="$program->status_program->value">{{ $program->status_program->label() }}</x-badge-status>
                    </div>
                    <div class="row g-2">
                        @foreach($program->kegiatan as $kegiatan)
                        <div class="col-md-6">
                            <div class="card card-sm bg-light border-0">
                                <div class="card-body py-2">
                                    <div class="fw-medium small">{{ $kegiatan->nama_kegiatan }}</div>
                                    <div class="text-secondary small">{{ $kegiatan->task_done_count }}/{{ $kegiatan->tasks_count }} task selesai</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @empty
                <div class="list-group-item text-center text-secondary py-4">Pegawai ini belum punya program yang terkait task.</div>
                @endforelse
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Task Pegawai</h3>
                <div class="card-options">
                    <span class="text-secondary small">{{ $tasks->count() }} task</span>
                </div>
            </div>
            <div class="list-group list-group-flush">
                @forelse($tasks as $task)
                <div class="list-group-item">
                    <div class="d-flex align-items-start justify-content-between gap-2">
                        <div>
                            <a href="{{ route('task.show', $task) }}" class="fw-medium text-body">{{ $task->nama_task }}</a>
                            <div class="text-secondary small">{{ $task->kegiatan->programKerja->nama_program }} · {{ $task->kegiatan->nama_kegiatan }}</div>
                        </div>
                        <div class="d-flex align-items-center gap-2 flex-shrink-0">
                            <span class="text-secondary small">{{ $task->progress_persen }}%</span>
                            <x-badge-status :status="$task->status->value">{{ $task->status->label() }}</x-badge-status>
                        </div>
                    </div>
                    <div class="progress progress-sm mt-2">
                        <div class="progress-bar bg-primary" style="width: {{ $task->progress_persen }}%"></div>
                    </div>

                    @if($task->dailyScrums->count())
                    <div class="mt-2 d-flex flex-column gap-1">
                        @foreach($task->dailyScrums as $scrum)
                        <div class="card card-sm bg-light border-0">
                            <div class="card-body py-2">
                                <div class="d-flex justify-content-between">
                                    <span class="small fw-medium text-secondary">{{ $scrum->tanggal->format('d M Y') }}</span>
                                    <span class="small text-secondary">{{ $scrum->pegawai->nama_pegawai }}</span>
                                </div>
                                <div class="small mt-1">{{ $scrum->rencana_kerja_harian }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                @empty
                <div class="list-group-item text-center text-secondary py-4">Tidak ada task</div>
                @endforelse
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daily Scrum Terbaru</h3>
                <div class="card-options">
                    <span class="text-secondary small">{{ $dailyScrums->count() }} entri</span>
                </div>
            </div>
            <div class="list-group list-group-flush">
                @forelse($dailyScrums as $scrum)
                <div class="list-group-item">
                    <div class="d-flex align-items-center justify-content-between gap-2">
                        <span class="fw-medium small">{{ $scrum->task->nama_task }}</span>
                        <span class="text-secondary small">{{ $scrum->tanggal->format('d M Y') }}</span>
                    </div>
                    <div class="text-secondary small">{{ $scrum->task->kegiatan->programKerja->nama_program }} · {{ $scrum->task->kegiatan->nama_kegiatan }}</div>
                    <div class="mt-1 small">{{ $scrum->rencana_kerja_harian }}</div>
                </div>
                @empty
                <div class="list-group-item text-center text-secondary py-4">Belum ada daily scrum</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
