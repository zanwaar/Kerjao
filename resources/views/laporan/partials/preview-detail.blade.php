<div class="d-flex flex-column gap-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-primary text-uppercase small fw-semibold">Identitas Laporan</h3>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-sm-6 col-xl-auto flex-xl-fill">
                    <div class="card card-sm bg-light border-0">
                        <div class="card-body">
                            <div class="text-secondary small">Nama Pegawai</div>
                            <div class="fw-semibold">{{ $selectedPegawai?->nama_pegawai ?? 'Semua Pegawai' }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-auto flex-xl-fill">
                    <div class="card card-sm bg-light border-0">
                        <div class="card-body">
                            <div class="text-secondary small">Jabatan</div>
                            <div class="fw-semibold">{{ $selectedPegawai?->jabatan ?? '-' }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-auto flex-xl-fill">
                    <div class="card card-sm bg-light border-0">
                        <div class="card-body">
                            <div class="text-secondary small">Unit Kerja</div>
                            <div class="fw-semibold">{{ $selectedPegawai?->unit_kerja ?? '-' }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-auto flex-xl-fill">
                    <div class="card card-sm bg-light border-0">
                        <div class="card-body">
                            <div class="text-secondary small">Periode</div>
                            <div class="fw-semibold">{{ $periodeLabel }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-auto flex-xl-fill">
                    <div class="card card-sm bg-light border-0">
                        <div class="card-body">
                            <div class="text-secondary small">Tanggal Lapor</div>
                            <div class="fw-semibold">{{ $generatedAt->translatedFormat('d F Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-primary text-uppercase small fw-semibold">Ringkasan Kinerja Bulanan</h3>
        </div>
        <div class="card-body">
            <div class="row g-3 mb-3">
                <div class="col-6 col-lg-2">
                    <div class="card card-sm border">
                        <div class="card-body">
                            <div class="subheader">Total Task</div>
                            <div class="h1 mb-0">{{ $summary['total_task'] }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="card card-sm border">
                        <div class="card-body">
                            <div class="subheader">Task Selesai</div>
                            <div class="h1 mb-0 text-success">{{ $summary['task_selesai'] }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="card card-sm border">
                        <div class="card-body">
                            <div class="subheader">On Progress</div>
                            <div class="h1 mb-0 text-warning">{{ $summary['task_on_progress'] }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="card card-sm border">
                        <div class="card-body">
                            <div class="subheader">Tidak Selesai</div>
                            <div class="h1 mb-0 text-danger">{{ $summary['task_tidak_selesai'] }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="card card-sm border">
                        <div class="card-body">
                            <div class="subheader">Capaian</div>
                            <div class="h1 mb-0 text-primary">{{ $summary['persentase_capaian'] }}%</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="card card-sm border">
                        <div class="card-body">
                            <div class="subheader">Hari Kerja</div>
                            <div class="h1 mb-0">{{ $summary['total_hari_kerja'] }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card card-sm bg-light border-0">
                        <div class="card-body">
                            <div class="fw-semibold mb-2">WakaTime</div>
                            <div class="text-secondary small">Total Jam Kerja (Coding): <span class="fw-semibold text-body">{{ number_format($summary['total_jam_kerja'], 1) }} jam</span></div>
                            <div class="text-secondary small">Rata-rata per hari: <span class="fw-semibold text-body">{{ number_format($summary['rata_rata_jam_kerja'], 1) }} jam</span></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-sm bg-light border-0">
                        <div class="card-body">
                            <div class="fw-semibold mb-2">GitHub</div>
                            <div class="text-secondary small">Total Commit: <span class="fw-semibold text-body">{{ $summary['total_commit'] }}</span></div>
                            <div class="text-secondary small">Pull Request: <span class="fw-semibold text-body">{{ $summary['total_pull_request'] }}</span></div>
                            <div class="text-secondary small">Issue Tercatat: <span class="fw-semibold text-body">{{ $summary['total_issue'] }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-primary text-uppercase small fw-semibold">Rincian Program & Kegiatan</h3>
        </div>

        @forelse($programReports as $programReport)
        <div class="card-body border-bottom">
            <div class="d-flex align-items-center justify-content-between gap-2 mb-3">
                <div>
                    <div class="fw-semibold fs-5">{{ $programReport['program']->nama_program }}</div>
                    <div class="text-secondary small">{{ $programReport['program']->status_program->label() }}</div>
                </div>
                <x-badge-status :status="$programReport['program']->status_program->value">{{ $programReport['program']->status_program->label() }}</x-badge-status>
            </div>

            <div class="table-responsive">
                <table class="table table-vcenter card-table table-sm">
                    <thead>
                        <tr>
                            <th class="w-1">No</th>
                            <th>Kegiatan</th>
                            <th>Target</th>
                            <th>Realisasi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($programReport['kegiatan_rows'] as $row)
                        <tr>
                            <td class="text-secondary">{{ $loop->iteration }}</td>
                            <td class="fw-medium">{{ $row['kegiatan']->nama_kegiatan }}</td>
                            <td class="text-secondary">{{ $row['target'] }}</td>
                            <td class="text-secondary">{{ $row['realisasi'] }}</td>
                            <td class="text-secondary">{{ $row['status'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @empty
        <div class="card-body text-center text-secondary py-5">Tidak ada data program dan kegiatan pada periode ini.</div>
        @endforelse
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-primary text-uppercase small fw-semibold">Rincian Task</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th class="w-1">No</th>
                        <th>Task</th>
                        <th>Kegiatan</th>
                        <th>Assigned</th>
                        <th>Status</th>
                        <th>Progress</th>
                        <th>Due Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                    <tr>
                        <td class="text-secondary">{{ $loop->iteration }}</td>
                        <td>
                            <div class="fw-medium">{{ $task->nama_task }}</div>
                            @if($task->deskripsi_task)
                            <div class="text-secondary small">{{ \Illuminate\Support\Str::of($task->deskripsi_task)->squish()->limit(90) }}</div>
                            @endif
                        </td>
                        <td>
                            <div>{{ $task->kegiatan->nama_kegiatan }}</div>
                            <div class="text-secondary small">{{ $task->kegiatan->programKerja->nama_program }}</div>
                        </td>
                        <td class="text-secondary">{{ $task->assignee?->nama_pegawai ?? '-' }}</td>
                        <td><x-badge-status :status="$task->status->value">{{ $task->status->label() }}</x-badge-status></td>
                        <td class="text-secondary">{{ $task->progress_persen }}%</td>
                        <td class="text-secondary">{{ $task->due_date?->translatedFormat('d M Y') ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-secondary py-5">Tidak ada task pada periode ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-primary text-uppercase small fw-semibold">Ringkasan Aktivitas Harian</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Task</th>
                        <th>Rencana</th>
                        <th>Realisasi</th>
                        <th>Kendala</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($scrums as $scrum)
                    <tr>
                        <td class="text-secondary">{{ $scrum->tanggal->translatedFormat('d M Y') }}</td>
                        <td>
                            <div class="fw-medium">{{ $scrum->task->nama_task }}</div>
                            <div class="text-secondary small">{{ $scrum->pegawai->nama_pegawai }}</div>
                        </td>
                        <td class="text-secondary">{{ $scrum->rencana_kerja_harian }}</td>
                        <td class="text-secondary">{{ $scrum->realisasi ?: '-' }}</td>
                        <td class="text-secondary">{{ $scrum->potensi_risiko ?: '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-secondary py-5">Tidak ada daily scrum pada periode ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-primary text-uppercase small fw-semibold">Bukti Pencapaian</h3>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-xl-4">
                    <div class="fw-semibold mb-2">Dokumen / Output</div>
                    <div class="d-flex flex-column gap-2">
                        @forelse($evidence['bukti_aktivitas']->take(5) as $bukti)
                        <div class="card card-sm border">
                            <div class="card-body">
                                <div class="fw-medium">{{ $bukti->jenis_bukti->label() }}</div>
                                <div class="text-secondary small text-break mt-1">{{ $bukti->sumber_bukti }}</div>
                                @if($bukti->keterangan)
                                <div class="text-secondary small mt-1">{{ $bukti->keterangan }}</div>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="text-secondary small">Belum ada bukti aktivitas pada periode ini.</div>
                        @endforelse
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="fw-semibold mb-2">GitHub</div>
                    <div class="text-secondary small mb-2">Repo: <span class="fw-medium text-body">{{ $evidence['repos']->isNotEmpty() ? $evidence['repos']->join(', ') : '-' }}</span></div>
                    <div class="text-secondary small mb-2">PR Tercatat: <span class="fw-medium text-body">{{ $summary['total_pull_request'] }}</span></div>
                    <div class="fw-medium small mb-2">Commit Penting:</div>
                    <div class="d-flex flex-column gap-2">
                        @forelse($evidence['github_activities']->take(5) as $activity)
                        <div class="card card-sm border">
                            <div class="card-body">
                                <div class="fw-medium">{{ $activity->repo_name }}</div>
                                <div class="text-secondary small mt-1">{{ $activity->commit_hash ? substr($activity->commit_hash, 0, 7) : 'commit' }} · {{ $activity->commit_time?->translatedFormat('d M Y H:i') ?? '-' }}</div>
                                <div class="small mt-1">{{ $activity->commit_message ?: ($activity->pr_link ?: '-') }}</div>
                            </div>
                        </div>
                        @empty
                        <div class="text-secondary small">Tidak ada aktivitas GitHub pada periode ini.</div>
                        @endforelse
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="fw-semibold mb-2">WakaTime</div>
                    <div class="text-secondary small mb-3">Total durasi kerja: <span class="fw-medium text-body">{{ number_format($summary['total_jam_kerja'], 1) }} jam</span></div>
                    <div class="fw-medium small mb-2">Project yang dikerjakan:</div>
                    <div class="d-flex flex-column gap-1">
                        @forelse($evidence['project_durations'] as $project => $duration)
                        <div class="d-flex justify-content-between align-items-center border rounded px-3 py-2">
                            <span class="small">{{ $project }}</span>
                            <span class="fw-medium small">{{ number_format($duration, 1) }} jam</span>
                        </div>
                        @empty
                        <div class="text-secondary small">Tidak ada data WakaTime pada periode ini.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-primary text-uppercase small fw-semibold">Analisis Capaian</h3>
        </div>
        <div class="card-body">
            @foreach($analysis as $item)
            <p class="text-secondary mb-2">{{ $item }}</p>
            @endforeach
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title text-primary text-uppercase small fw-semibold">Kendala dan Permasalahan</h3>
                </div>
                <div class="card-body">
                    @foreach($obstacles as $item)
                    <div class="d-flex align-items-start gap-2 mb-2">
                        <span class="badge bg-danger mt-1 p-1"></span>
                        <span class="text-secondary small">{{ $item }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title text-primary text-uppercase small fw-semibold">Rencana Tindak Lanjut</h3>
                </div>
                <div class="card-body">
                    @foreach($followUps as $item)
                    <div class="d-flex align-items-start gap-2 mb-2">
                        <span class="badge bg-success mt-1 p-1"></span>
                        <span class="text-secondary small">{{ $item }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-primary text-uppercase small fw-semibold">Kesimpulan</h3>
        </div>
        <div class="card-body">
            <p class="text-secondary mb-0" style="line-height: 1.8">{{ $conclusion }}</p>
        </div>
    </div>
</div>
