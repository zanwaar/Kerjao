<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Bulanan {{ $periodeLabel }}</title>
    <style>
        @page {
            margin: 20px 24px 24px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            line-height: 1.45;
            color: #1f2937;
        }

        .header {
            border-bottom: 2px solid #1d4ed8;
            padding-bottom: 10px;
            margin-bottom: 14px;
        }

        .title {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
            color: #1d4ed8;
            letter-spacing: 0.04em;
        }

        .subtitle {
            margin-top: 4px;
            color: #6b7280;
            font-size: 10px;
        }

        .section {
            margin-top: 14px;
        }

        .section-title {
            margin: 0 0 8px;
            padding: 6px 8px;
            background: #eff6ff;
            border-left: 4px solid #2563eb;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #1e3a8a;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            display: table-header-group;
        }

        tr {
            page-break-inside: avoid;
        }

        th,
        td {
            border: 1px solid #d1d5db;
            padding: 6px 7px;
            vertical-align: top;
        }

        th {
            background: #f3f4f6;
            font-weight: bold;
            text-align: left;
            color: #374151;
        }

        .label-col {
            width: 18%;
            background: #f9fafb;
            font-weight: bold;
            color: #374151;
        }

        .summary-table td {
            text-align: center;
        }

        .summary-value {
            display: block;
            font-size: 18px;
            font-weight: bold;
            color: #1d4ed8;
            margin-bottom: 3px;
        }

        .summary-label {
            font-size: 8px;
            text-transform: uppercase;
            color: #6b7280;
        }

        .muted {
            color: #6b7280;
        }

        .small {
            font-size: 9px;
        }

        .paragraph {
            margin: 0 0 6px;
            text-align: justify;
        }

        .list {
            margin: 0;
            padding-left: 16px;
        }

        .list li {
            margin-bottom: 4px;
        }

        .subheading {
            margin: 8px 0 5px;
            font-size: 10px;
            font-weight: bold;
            color: #111827;
        }

        .footer {
            margin-top: 16px;
            padding-top: 8px;
            border-top: 1px solid #d1d5db;
            text-align: right;
            font-size: 9px;
            color: #6b7280;
        }

        .page-break {
            page-break-before: always;
        }

        .empty {
            color: #6b7280;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <p class="title">LAPORAN BULANAN KEGIATAN</p>
        <div class="subtitle">Periode {{ $periodeLabel }} · Dicetak {{ $generatedAt->translatedFormat('d F Y H:i') }}</div>
    </div>

    <div class="section">
        <p class="section-title">1. Identitas Laporan</p>
        <table>
            <tbody>
                <tr>
                    <td class="label-col">Nama Pegawai</td>
                    <td>{{ $selectedPegawai?->nama_pegawai ?? 'Semua Pegawai' }}</td>
                    <td class="label-col">Periode</td>
                    <td>{{ $periodeLabel }}</td>
                </tr>
                <tr>
                    <td class="label-col">Jabatan</td>
                    <td>{{ $selectedPegawai?->jabatan ?? '-' }}</td>
                    <td class="label-col">Tanggal Lapor</td>
                    <td>{{ $generatedAt->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <td class="label-col">Unit Kerja</td>
                    <td>{{ $selectedPegawai?->unit_kerja ?? '-' }}</td>
                    <td class="label-col">Program Kerja</td>
                    <td>{{ $selectedProgram?->nama_program ?? 'Semua Program' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <p class="section-title">2. Ringkasan Kinerja Bulanan</p>
        <table class="summary-table">
            <tbody>
                <tr>
                    <td>
                        <span class="summary-value">{{ $summary['total_task'] }}</span>
                        <span class="summary-label">Total Task</span>
                    </td>
                    <td>
                        <span class="summary-value">{{ $summary['task_selesai'] }}</span>
                        <span class="summary-label">Task Selesai</span>
                    </td>
                    <td>
                        <span class="summary-value">{{ $summary['task_on_progress'] }}</span>
                        <span class="summary-label">Task On Progress</span>
                    </td>
                    <td>
                        <span class="summary-value">{{ $summary['task_tidak_selesai'] }}</span>
                        <span class="summary-label">Task Tidak Selesai</span>
                    </td>
                    <td>
                        <span class="summary-value">{{ $summary['persentase_capaian'] }}%</span>
                        <span class="summary-label">Persentase Capaian</span>
                    </td>
                    <td>
                        <span class="summary-value">{{ $summary['total_hari_kerja'] }}</span>
                        <span class="summary-label">Total Hari Kerja</span>
                    </td>
                </tr>
            </tbody>
        </table>

        <table style="margin-top: 8px;">
            <tbody>
                <tr>
                    <td class="label-col">Total Jam Kerja (Coding)</td>
                    <td>{{ number_format($summary['total_jam_kerja'], 1) }} jam</td>
                    <td class="label-col">Total Commit</td>
                    <td>{{ $summary['total_commit'] }}</td>
                </tr>
                <tr>
                    <td class="label-col">Rata-rata per hari</td>
                    <td>{{ number_format($summary['rata_rata_jam_kerja'], 1) }} jam</td>
                    <td class="label-col">Pull Request</td>
                    <td>{{ $summary['total_pull_request'] }}</td>
                </tr>
                <tr>
                    <td class="label-col">Issue Tercatat</td>
                    <td>{{ $summary['total_issue'] }}</td>
                    <td class="label-col">Daily Scrum</td>
                    <td>{{ $summary['total_scrum'] }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <p class="section-title">3. Rincian Program & Kegiatan</p>
        @forelse($programReports as $programReport)
        <p class="subheading">{{ $programReport['program']->nama_program }} · {{ $programReport['program']->status_program->label() }}</p>
        <table style="margin-bottom: 8px;">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 24%;">Kegiatan</th>
                    <th style="width: 25%;">Target</th>
                    <th style="width: 31%;">Realisasi</th>
                    <th style="width: 15%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($programReport['kegiatan_rows'] as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row['kegiatan']->nama_kegiatan }}</td>
                    <td>{{ $row['target'] }}</td>
                    <td>{{ $row['realisasi'] }}</td>
                    <td>{{ $row['status'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @empty
        <p class="empty">Tidak ada data program dan kegiatan pada periode ini.</p>
        @endforelse
    </div>

    <div class="section">
        <p class="section-title">4. Rincian Task (Todo List)</p>
        @if($tasks->isNotEmpty())
        <table>
            <thead>
                <tr>
                    <th style="width: 4%;">No</th>
                    <th style="width: 18%;">Task</th>
                    <th style="width: 18%;">Kegiatan</th>
                    <th style="width: 14%;">Assigned</th>
                    <th style="width: 14%;">Status</th>
                    <th style="width: 10%;">Progress</th>
                    <th style="width: 10%;">Due Date</th>
                    <th style="width: 12%;">Prioritas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <strong>{{ $task->nama_task }}</strong>
                        @if($task->deskripsi_task)
                        <div class="muted small">{{ \Illuminate\Support\Str::of($task->deskripsi_task)->squish()->limit(85) }}</div>
                        @endif
                    </td>
                    <td>
                        {{ $task->kegiatan->nama_kegiatan }}
                        <div class="muted small">{{ $task->kegiatan->programKerja->nama_program }}</div>
                    </td>
                    <td>{{ $task->assignee?->nama_pegawai ?? '-' }}</td>
                    <td>{{ $task->status->label() }}</td>
                    <td>{{ $task->progress_persen }}%</td>
                    <td>{{ $task->due_date?->translatedFormat('d M Y') ?? '-' }}</td>
                    <td>{{ $task->prioritas->label() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p class="empty">Tidak ada task pada periode ini.</p>
        @endif
    </div>

    <div class="section page-break">
        <p class="section-title">5. Ringkasan Aktivitas Harian (Daily Scrum)</p>
        @if($scrums->isNotEmpty())
        <table>
            <thead>
                <tr>
                    <th style="width: 11%;">Tanggal</th>
                    <th style="width: 18%;">Task</th>
                    <th style="width: 24%;">Rencana</th>
                    <th style="width: 24%;">Realisasi</th>
                    <th style="width: 23%;">Kendala</th>
                </tr>
            </thead>
            <tbody>
                @foreach($scrums as $scrum)
                <tr>
                    <td>{{ $scrum->tanggal->translatedFormat('d M Y') }}</td>
                    <td>
                        {{ $scrum->task->nama_task }}
                        <div class="muted small">{{ $scrum->pegawai->nama_pegawai }}</div>
                    </td>
                    <td>{{ $scrum->rencana_kerja_harian }}</td>
                    <td>{{ $scrum->realisasi ?: '-' }}</td>
                    <td>{{ $scrum->potensi_risiko ?: '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p class="empty">Tidak ada daily scrum pada periode ini.</p>
        @endif
    </div>

    <div class="section">
        <p class="section-title">6. Bukti Pencapaian</p>

        <p class="subheading">Dokumen / Output</p>
        @if($evidence['bukti_aktivitas']->isNotEmpty())
        <table>
            <thead>
                <tr>
                    <th style="width: 12%;">Jenis</th>
                    <th style="width: 48%;">Sumber Bukti</th>
                    <th style="width: 40%;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($evidence['bukti_aktivitas']->take(8) as $bukti)
                <tr>
                    <td>{{ $bukti->jenis_bukti->label() }}</td>
                    <td>{{ $bukti->sumber_bukti }}</td>
                    <td>{{ $bukti->keterangan ?: '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p class="empty">Belum ada bukti aktivitas pada periode ini.</p>
        @endif

        <p class="subheading">GitHub</p>
        <table>
            <tbody>
                <tr>
                    <td class="label-col">Repo</td>
                    <td>{{ $evidence['repos']->isNotEmpty() ? $evidence['repos']->join(', ') : '-' }}</td>
                    <td class="label-col">PR Tercatat</td>
                    <td>{{ $summary['total_pull_request'] }}</td>
                </tr>
            </tbody>
        </table>
        @if($evidence['github_activities']->isNotEmpty())
        <table style="margin-top: 6px;">
            <thead>
                <tr>
                    <th style="width: 20%;">Repo</th>
                    <th style="width: 15%;">Commit</th>
                    <th style="width: 18%;">Waktu</th>
                    <th style="width: 47%;">Pesan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($evidence['github_activities']->take(8) as $activity)
                <tr>
                    <td>{{ $activity->repo_name }}</td>
                    <td>{{ $activity->commit_hash ? substr($activity->commit_hash, 0, 7) : '-' }}</td>
                    <td>{{ $activity->commit_time?->translatedFormat('d M Y H:i') ?? '-' }}</td>
                    <td>{{ $activity->commit_message ?: ($activity->pr_link ?: '-') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p class="empty">Tidak ada aktivitas GitHub pada periode ini.</p>
        @endif

        <p class="subheading">WakaTime</p>
        <table>
            <tbody>
                <tr>
                    <td class="label-col">Total Durasi Kerja</td>
                    <td>{{ number_format($summary['total_jam_kerja'], 1) }} jam</td>
                    <td class="label-col">Project yang Dikerjakan</td>
                    <td>{{ $evidence['project_durations']->isNotEmpty() ? $evidence['project_durations']->keys()->join(', ') : '-' }}</td>
                </tr>
            </tbody>
        </table>
        @if($evidence['project_durations']->isNotEmpty())
        <table style="margin-top: 6px;">
            <thead>
                <tr>
                    <th style="width: 70%;">Project</th>
                    <th style="width: 30%;">Durasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($evidence['project_durations'] as $project => $duration)
                <tr>
                    <td>{{ $project }}</td>
                    <td>{{ number_format($duration, 1) }} jam</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p class="empty">Tidak ada data WakaTime pada periode ini.</p>
        @endif
    </div>

    <div class="section">
        <p class="section-title">7. Analisis Capaian</p>
        @foreach($analysis as $item)
        <p class="paragraph">{{ $item }}</p>
        @endforeach
    </div>

    <div class="section">
        <p class="section-title">8. Kendala dan Permasalahan</p>
        <ul class="list">
            @foreach($obstacles as $item)
            <li>{{ $item }}</li>
            @endforeach
        </ul>
    </div>

    <div class="section">
        <p class="section-title">9. Rencana Tindak Lanjut</p>
        <ul class="list">
            @foreach($followUps as $item)
            <li>{{ $item }}</li>
            @endforeach
        </ul>
    </div>

    <div class="section">
        <p class="section-title">10. Kesimpulan</p>
        <p class="paragraph">{{ $conclusion }}</p>
    </div>

    <div class="footer">Kerjao · Laporan Bulanan · {{ $generatedAt->translatedFormat('d F Y H:i') }}</div>
</body>
</html>
