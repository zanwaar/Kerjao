@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@if($canViewAllTasks)
@php
    $adminStats = [
        [
            'label' => $selectedPegawai ? 'Pegawai Dipilih' : 'Pegawai Aktif',
            'value' => $selectedPegawai ? $selectedPegawai->nama_pegawai : $totalPegawaiAktif,
            'color' => 'text-primary',
        ],
        [
            'label' => 'Program Aktif',
            'value' => $totalProgramAktif,
            'color' => 'text-azure',
        ],
        [
            'label' => 'Task Berjalan',
            'value' => $taskOnProgress,
            'color' => 'text-warning',
        ],
        [
            'label' => 'Scrum Tercatat',
            'value' => $scrumTerbaru->count(),
            'color' => 'text-success',
        ],
    ];
@endphp

<div class="row row-deck row-cards mb-3">
    @foreach($adminStats as $stat)
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="text-secondary text-uppercase small fw-bold">{{ $stat['label'] }}</div>
                <div class="h2 mt-2 mb-0 {{ $stat['color'] }}">{{ $stat['value'] }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row row-cards">
    <div class="col-xl-8">
        <div class="row row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h3 class="card-title">Pantauan Aktivitas Pegawai</h3>
                            <div class="text-secondary small">
                                Ringkasan task aktif, task selesai, dan jejak aktivitas hari ini. Klik baris pegawai untuk membuka detail program, task, dan daily scrum.
                            </div>
                        </div>
                        <div class="card-actions">
                            @if($selectedPegawai)
                            <a href="{{ route('dashboard') }}" class="btn btn-ghost-secondary btn-sm">Lihat semua</a>
                            @endif
                            <a href="{{ route('pegawai.index') }}" class="btn btn-primary btn-sm">Kelola Pegawai</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>Pegawai</th>
                                    <th>Task Aktif</th>
                                    <th>Task Selesai</th>
                                    <th>Scrum Hari Ini</th>
                                    <th>Aktivitas Hari Ini</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($aktivitasPegawai as $pegawai)
                                @php
                                    $isSelectedPegawai = $selectedPegawai?->id === $pegawai->id;
                                    $dashboardPegawaiUrl = route('dashboard', ['pegawai_id' => $pegawai->id]);
                                @endphp
                                <tr @class(['table-active' => $isSelectedPegawai])>
                                    <td>
                                        <a href="{{ $dashboardPegawaiUrl }}" class="text-reset text-decoration-none">
                                            <div class="fw-medium {{ $isSelectedPegawai ? 'text-primary' : '' }}">{{ $pegawai->nama_pegawai }}</div>
                                            <div class="text-secondary small">{{ $pegawai->jabatan }} · {{ $pegawai->unit_kerja }}</div>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ $dashboardPegawaiUrl }}" class="text-reset text-decoration-none {{ $isSelectedPegawai ? 'fw-bold text-primary' : '' }}">
                                            {{ $pegawai->task_aktif_count }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ $dashboardPegawaiUrl }}" class="text-reset text-decoration-none {{ $isSelectedPegawai ? 'fw-bold text-primary' : '' }}">
                                            {{ $pegawai->task_selesai_count }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ $dashboardPegawaiUrl }}" class="text-reset text-decoration-none {{ $isSelectedPegawai ? 'fw-bold text-primary' : '' }}">
                                            {{ $pegawai->scrum_hari_ini_count }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ $dashboardPegawaiUrl }}" class="text-reset text-decoration-none">
                                            <div class="d-flex flex-wrap gap-2">
                                                <span class="badge {{ $isSelectedPegawai ? 'bg-primary-lt text-primary' : 'bg-secondary-lt text-secondary' }}">Bukti {{ $pegawai->bukti_hari_ini_count }}</span>
                                                <span class="badge {{ $isSelectedPegawai ? 'bg-primary-lt text-primary' : 'bg-secondary-lt text-secondary' }}">GitHub {{ $pegawai->github_hari_ini_count }}</span>
                                                <span class="badge {{ $isSelectedPegawai ? 'bg-primary-lt text-primary' : 'bg-secondary-lt text-secondary' }}">WakaTime {{ $pegawai->wakatime_hari_ini_count }}</span>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-secondary py-5">Belum ada data pegawai aktif.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if($selectedPegawai)
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h3 class="card-title">Ringkasan {{ $selectedPegawai->nama_pegawai }}</h3>
                            <div class="text-secondary small">Program, task, dan progres harian pegawai terpilih langsung dari dashboard.</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row row-cards">
                            <div class="col-12">
                                <h4 class="mb-3">Program Terkait</h4>
                                <div class="row row-cards">
                                    @forelse($programMonitor as $program)
                                    @php
                                        $programTasks = $program->kegiatan->flatMap->tasks;
                                        $programAverageProgress = (int) round($programTasks->avg('progress_persen') ?? 0);
                                    @endphp
                                    <div class="col-md-6">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="d-flex align-items-start justify-content-between gap-3">
                                                    <div>
                                                        <a href="{{ route('program-kerja.show', $program) }}" class="text-reset fw-medium text-decoration-none">
                                                            {{ $program->nama_program }}
                                                        </a>
                                                        <div class="text-secondary small mt-1">{{ $programTasks->count() }} task untuk pegawai ini</div>
                                                    </div>
                                                    <x-badge-status :status="$program->status_program->value">{{ $program->status_program->label() }}</x-badge-status>
                                                </div>
                                                <div class="progress progress-sm mt-3">
                                                    <div class="progress-bar bg-primary" style="width: {{ $programAverageProgress }}%" role="progressbar" aria-valuenow="{{ $programAverageProgress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="col-12">
                                        <div class="empty">
                                            <div class="empty-title">Belum ada program terkait</div>
                                            <p class="empty-subtitle text-secondary">Pegawai ini belum punya program yang terkait task.</p>
                                        </div>
                                    </div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="col-12">
                                <h4 class="mb-3">Task Pegawai</h4>
                                <div class="list-group list-group-flush">
                                    @forelse($selectedPegawaiTasks as $task)
                                    <div class="list-group-item px-0">
                                        <div class="d-flex align-items-start justify-content-between gap-3">
                                            <div>
                                                <a href="{{ route('task.show', $task) }}" class="text-reset fw-medium text-decoration-none">
                                                    {{ $task->nama_task }}
                                                </a>
                                                <div class="text-secondary small mt-1">
                                                    {{ $task->kegiatan->programKerja->nama_program }} · {{ $task->kegiatan->nama_kegiatan }}
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge bg-secondary-lt text-secondary">{{ $task->daily_scrums_count }} scrum</span>
                                                <x-badge-status :status="$task->status->value">{{ $task->status->label() }}</x-badge-status>
                                            </div>
                                        </div>
                                        <div class="progress progress-sm mt-3">
                                            <div class="progress-bar bg-primary" style="width: {{ $task->progress_persen }}%" role="progressbar" aria-valuenow="{{ $task->progress_persen }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="empty py-4">
                                        <div class="empty-title">Belum ada task</div>
                                        <p class="empty-subtitle text-secondary">Belum ada task untuk pegawai yang dipilih.</p>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h3 class="card-title">Total Program</h3>
                            <div class="text-secondary small">Admin memantau progres program dari satu pintu.</div>
                        </div>
                        <div class="card-actions">
                            <a href="{{ route('program-kerja.index') }}" class="btn btn-ghost-primary btn-sm">Lihat semua program</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row row-cards">
                            @forelse($programMonitor as $program)
                            @php
                                $programTasks = $program->kegiatan->flatMap->tasks;
                                $programTaskCount = $programTasks->count();
                                $programDoneCount = $programTasks->where('status', \App\Enums\StatusTask::Done)->count();
                                $programAverageProgress = (int) round($programTasks->avg('progress_persen') ?? 0);
                            @endphp
                            <div class="col-md-6">
                                <div class="card card-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start justify-content-between gap-3">
                                            <div>
                                                <a href="{{ route('program-kerja.show', $program) }}" class="text-reset fw-medium text-decoration-none">
                                                    {{ $program->nama_program }}
                                                </a>
                                                <div class="text-secondary small mt-1">
                                                    {{ $program->kegiatan->count() }} kegiatan · {{ $programTaskCount }} task
                                                </div>
                                            </div>
                                            <x-badge-status :status="$program->status_program->value">{{ $program->status_program->label() }}</x-badge-status>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-3 small">
                                            <span class="text-secondary">Selesai {{ $programDoneCount }}/{{ $programTaskCount }}</span>
                                            <span class="fw-bold text-primary">{{ $programAverageProgress }}%</span>
                                        </div>
                                        <div class="progress progress-sm mt-2">
                                            <div class="progress-bar bg-primary" style="width: {{ $programAverageProgress }}%" role="progressbar" aria-valuenow="{{ $programAverageProgress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="empty">
                                    <div class="empty-title">Belum ada program</div>
                                    <p class="empty-subtitle text-secondary">Belum ada program untuk dipantau.</p>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="col-xl-4">
        <div class="row row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $selectedPegawai ? 'Daily Scrum Pegawai' : 'Daily Scrum Terbaru' }}</h3>
                        <div class="card-actions">
                            <a href="{{ route('laporan.index') }}" class="btn btn-ghost-primary btn-sm">Laporan</a>
                        </div>
                    </div>
                    <div class="list-group list-group-flush">
                        @forelse($scrumTerbaru as $scrum)
                        <div class="list-group-item">
                            <div class="d-flex align-items-start justify-content-between gap-3">
                                <div>
                                    <div class="fw-medium">{{ $scrum->pegawai->nama_pegawai }}</div>
                                    <div class="text-secondary small mt-1">
                                        {{ $scrum->task->kegiatan->programKerja->nama_program }} · {{ $scrum->task->nama_task }}
                                    </div>
                                </div>
                                <div class="text-secondary small text-nowrap">{{ $scrum->tanggal->format('d M Y') }}</div>
                            </div>
                            <p class="text-secondary small mt-2 mb-0">{{ \Illuminate\Support\Str::limit($scrum->rencana_kerja_harian, 160) }}</p>
                        </div>
                        @empty
                        <div class="list-group-item text-center text-secondary py-5">Belum ada daily scrum terbaru.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $selectedPegawai ? 'Task Terlambat Pegawai' : 'Task Terlambat' }}</h3>
                        <div class="card-actions">
                            <span class="badge bg-danger-lt text-danger">{{ $taskOverdue->count() }}</span>
                        </div>
                    </div>
                    <div class="list-group list-group-flush">
                        @forelse($taskOverdue as $task)
                        <div class="list-group-item">
                            <a href="{{ route('program-kerja.show', $task->kegiatan->programKerja) }}" class="text-reset fw-medium text-decoration-none">
                                {{ $task->nama_task }}
                            </a>
                            <div class="text-secondary small mt-1">
                                {{ $task->kegiatan->programKerja->nama_program }} · {{ $task->assignee?->nama_pegawai ?? '-' }}
                            </div>
                            <div class="text-danger small fw-bold mt-2">Due {{ $task->due_date?->format('d M Y') }}</div>
                        </div>
                        @empty
                        <div class="list-group-item text-center text-secondary py-5">Tidak ada task overdue.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
@php
    $pegawaiStats = [
        [
            'label' => $canViewAllTasks ? 'Program Aktif' : 'Program Saya',
            'value' => $totalProgramAktif,
            'color' => 'text-primary',
        ],
        [
            'label' => $canViewAllTasks ? 'Kegiatan Aktif' : 'Kegiatan Saya',
            'value' => $totalKegiatanAktif,
            'color' => 'text-azure',
        ],
        [
            'label' => $canViewAllTasks ? 'Total Task' : 'Task Saya',
            'value' => $totalTask,
            'color' => 'text-secondary',
        ],
        [
            'label' => 'Task Selesai',
            'value' => $taskSelesai,
            'color' => 'text-success',
        ],
        [
            'label' => 'On Progress',
            'value' => $taskOnProgress,
            'color' => 'text-warning',
        ],
    ];
@endphp

<div class="row row-deck row-cards mb-3">
    @foreach($pegawaiStats as $stat)
    <div class="col-sm-6 col-xl">
        <div class="card">
            <div class="card-body">
                <div class="text-secondary text-uppercase small fw-bold">{{ $stat['label'] }}</div>
                <div class="h2 mt-2 mb-0 {{ $stat['color'] }}">{{ $stat['value'] }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row row-cards">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $canViewAllTasks ? 'Task Overdue' : 'Task Saya Terlambat' }}</h3>
                <div class="card-actions">
                    <span class="badge bg-danger-lt text-danger">{{ $taskOverdue->count() }}</span>
                </div>
            </div>
            <div class="list-group list-group-flush">
                @forelse($taskOverdue as $task)
                <div class="list-group-item">
                    <div class="d-flex align-items-start justify-content-between gap-3">
                        <div>
                            <a href="{{ route('task.show', $task) }}" class="text-reset fw-medium text-decoration-none">
                                {{ $task->nama_task }}
                            </a>
                            <div class="text-secondary small mt-1">
                                {{ $task->kegiatan->programKerja->nama_program }} · {{ $task->kegiatan->nama_kegiatan }}
                                @if($canViewAllTasks && $task->assignee)
                                · {{ $task->assignee->nama_pegawai }}
                                @endif
                            </div>
                        </div>
                        <span class="badge bg-danger-lt text-danger">{{ $task->due_date?->format('d M') }}</span>
                    </div>
                </div>
                @empty
                <div class="list-group-item text-center text-secondary py-5">Tidak ada task overdue</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="row row-cards">
            @if($taskSaya->isNotEmpty())
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Task Saya</h3>
                        <div class="card-actions">
                            <a href="{{ route('task.saya') }}" class="btn btn-ghost-primary btn-sm">Lihat semua</a>
                        </div>
                    </div>
                    <div class="list-group list-group-flush">
                        @foreach($taskSaya as $task)
                        <div class="list-group-item">
                            <div class="d-flex align-items-start justify-content-between gap-3 mb-2">
                                <a href="{{ route('task.show', $task) }}" class="text-reset fw-medium text-decoration-none">
                                    {{ $task->nama_task }}
                                </a>
                                <x-badge-status :status="$task->prioritas->value">{{ $task->prioritas->label() }}</x-badge-status>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress progress-sm flex-grow-1">
                                    <div class="progress-bar bg-primary" style="width: {{ $task->progress_persen }}%" role="progressbar" aria-valuenow="{{ $task->progress_persen }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="text-secondary small">{{ $task->progress_persen }}%</span>
                            </div>
                            <div class="text-secondary small mt-2">
                                {{ $task->kegiatan->programKerja->nama_program }} · {{ $task->kegiatan->nama_kegiatan }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Scrum Hari Ini</h3>
                        <div class="card-actions">
                            <a href="{{ route('daily-scrum.create') }}" class="btn btn-primary btn-sm">Tambah</a>
                        </div>
                    </div>
                    <div class="list-group list-group-flush">
                        @forelse($scrumHariIni as $scrum)
                        <div class="list-group-item">
                            <div class="fw-medium">{{ $scrum->task->nama_task }}</div>
                            <p class="text-secondary small mt-1 mb-0">{{ \Illuminate\Support\Str::limit($scrum->rencana_kerja_harian, 140) }}</p>
                        </div>
                        @empty
                        <div class="list-group-item text-center py-5">
                            <div class="text-secondary">Belum ada scrum hari ini</div>
                            <a href="{{ route('daily-scrum.create') }}" class="btn btn-ghost-primary btn-sm mt-3">Isi sekarang</a>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
