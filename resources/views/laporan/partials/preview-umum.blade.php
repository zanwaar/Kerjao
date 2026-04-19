<div class="d-flex flex-column gap-3">
    <div class="card border-primary">
        <div class="card-body">
            <div class="row align-items-start g-4">
                <div class="col-lg-7">
                    <div class="text-primary text-uppercase small fw-semibold mb-1">Mode Umum</div>
                    <h2 class="fs-4 fw-semibold mb-2">Ringkasan capaian kerja yang lebih mudah dipahami</h2>
                    <p class="text-secondary mb-0" style="line-height: 1.8">{{ $generalReport['headline'] }}</p>
                </div>
                <div class="col-lg-5">
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="card card-sm bg-light border-0">
                                <div class="card-body">
                                    <div class="text-secondary small">Nama Pegawai</div>
                                    <div class="fw-semibold small">{{ $selectedPegawai?->nama_pegawai ?? 'Semua Pegawai' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card card-sm bg-light border-0">
                                <div class="card-body">
                                    <div class="text-secondary small">Periode</div>
                                    <div class="fw-semibold small">{{ $periodeLabel }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card card-sm bg-light border-0">
                                <div class="card-body">
                                    <div class="text-secondary small">Program</div>
                                    <div class="fw-semibold small">{{ $selectedProgram?->nama_program ?? 'Beragam Program' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card card-sm bg-light border-0">
                                <div class="card-body">
                                    <div class="text-secondary small">Tanggal Lapor</div>
                                    <div class="fw-semibold small">{{ $generatedAt->translatedFormat('d F Y') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">Pekerjaan Tercatat</div>
                    <div class="h1 mb-2">{{ $summary['total_task'] }}</div>
                    <div class="text-secondary small">Total pekerjaan yang dipantau selama periode ini.</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">Pekerjaan Selesai</div>
                    <div class="h1 mb-2 text-success">{{ $summary['task_selesai'] }}</div>
                    <div class="text-secondary small">Bagian pekerjaan yang sudah tuntas dikerjakan.</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">Capaian</div>
                    <div class="h1 mb-2 text-primary">{{ $summary['persentase_capaian'] }}%</div>
                    <div class="text-secondary small">Gambaran umum tingkat penyelesaian target bulanan.</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">Aktivitas Harian</div>
                    <div class="h1 mb-2">{{ $summary['total_scrum'] }}</div>
                    <div class="text-secondary small">Catatan aktivitas yang mendukung progres pekerjaan.</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-primary text-uppercase small fw-semibold">Poin Capaian Utama</h3>
        </div>
        <div class="card-body">
            <div class="d-flex flex-column gap-2">
                @foreach($generalReport['achievement_points'] as $point)
                <div class="d-flex align-items-start gap-2 rounded border bg-light px-3 py-2">
                    <span class="badge bg-primary mt-1 p-1"></span>
                    <span class="text-secondary small">{{ $point }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-primary text-uppercase small fw-semibold">Gambaran Per Program</h3>
        </div>
        <div class="card-body">
            <div class="d-flex flex-column gap-3">
                @forelse($generalReport['program_highlights'] as $highlight)
                <div class="card border">
                    <div class="card-body">
                        <div class="row align-items-start g-3">
                            <div class="col-md-8">
                                <div class="fw-semibold fs-5 mb-2">{{ $highlight['program']->nama_program }}</div>
                                <p class="text-secondary mb-0" style="line-height: 1.8">{{ $highlight['narrative'] }}</p>
                            </div>
                            <div class="col-md-4">
                                <div class="row g-2">
                                    <div class="col-4">
                                        <div class="card card-sm bg-light border-0 text-center">
                                            <div class="card-body py-2">
                                                <div class="text-secondary small">Total</div>
                                                <div class="fw-semibold">{{ $highlight['task_total'] }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="card card-sm bg-light border-0 text-center">
                                            <div class="card-body py-2">
                                                <div class="text-secondary small">Selesai</div>
                                                <div class="fw-semibold text-success">{{ $highlight['task_completed'] }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="card card-sm bg-light border-0 text-center">
                                            <div class="card-body py-2">
                                                <div class="text-secondary small">Progres</div>
                                                <div class="fw-semibold text-primary">{{ $highlight['progress'] }}%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="border border-dashed rounded text-center text-secondary py-5">Belum ada data program pada periode ini.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-xl-6">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title text-primary text-uppercase small fw-semibold">Aktivitas Utama Selama Bulan Ini</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-2">
                        @forelse($generalReport['activity_digest'] as $item)
                        <div class="card card-sm bg-light border-0">
                            <div class="card-body py-2 text-secondary small">{{ $item }}</div>
                        </div>
                        @empty
                        <div class="text-secondary small">Belum ada ringkasan aktivitas pada periode ini.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title text-primary text-uppercase small fw-semibold">Dampak dan Hasil</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-2">
                        @foreach($generalReport['impact_points'] as $item)
                        <div class="card card-sm bg-light border-0">
                            <div class="card-body py-2 text-secondary small">{{ $item }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-xl-6">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title text-primary text-uppercase small fw-semibold">Kendala Singkat</h3>
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
        <div class="col-xl-6">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title text-primary text-uppercase small fw-semibold">Tindak Lanjut</h3>
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

    <div class="card bg-dark text-white">
        <div class="card-header border-0">
            <h3 class="card-title text-primary-lt text-uppercase small fw-semibold">Kesimpulan Umum</h3>
        </div>
        <div class="card-body">
            <p class="mb-0" style="line-height: 1.8">{{ $generalReport['simple_conclusion'] }}</p>
        </div>
    </div>
</div>
