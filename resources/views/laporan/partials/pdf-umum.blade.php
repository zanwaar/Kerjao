<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Bulanan Umum {{ $periodeLabel }}</title>
    <style>
        @page {
            margin: 22px 24px 26px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10.5px;
            line-height: 1.5;
            color: #1f2937;
        }

        .header {
            margin-bottom: 14px;
            padding-bottom: 10px;
            border-bottom: 2px solid #0f766e;
        }

        .eyebrow {
            margin: 0 0 4px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #0f766e;
        }

        .title {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
            color: #0f172a;
        }

        .subtitle {
            margin-top: 5px;
            color: #475569;
            font-size: 10px;
        }

        .lead {
            margin: 12px 0 0;
            padding: 10px 12px;
            background: #f0fdfa;
            border: 1px solid #99f6e4;
            border-radius: 4px;
        }

        .section {
            margin-top: 14px;
        }

        .section-title {
            margin: 0 0 8px;
            padding: 6px 8px;
            background: #f8fafc;
            border-left: 4px solid #14b8a6;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #134e4a;
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
            border: 1px solid #dbe3ea;
            padding: 7px 8px;
            vertical-align: top;
        }

        th {
            background: #f8fafc;
            color: #334155;
            font-weight: bold;
            text-align: left;
        }

        .label-col {
            width: 24%;
            background: #f8fafc;
            font-weight: bold;
            color: #334155;
        }

        .summary td {
            text-align: center;
        }

        .summary-value {
            display: block;
            font-size: 17px;
            font-weight: bold;
            color: #0f766e;
        }

        .summary-label {
            display: block;
            margin-top: 2px;
            font-size: 8px;
            text-transform: uppercase;
            color: #64748b;
        }

        .list {
            margin: 0;
            padding-left: 16px;
        }

        .list li {
            margin-bottom: 5px;
        }

        .paragraph {
            margin: 0 0 7px;
            text-align: justify;
        }

        .empty {
            color: #64748b;
            font-style: italic;
        }

        .footer {
            margin-top: 18px;
            padding-top: 8px;
            border-top: 1px solid #dbe3ea;
            text-align: right;
            font-size: 9px;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="header">
        <p class="eyebrow">Mode Umum</p>
        <p class="title">LAPORAN BULANAN KEGIATAN</p>
        <div class="subtitle">Periode {{ $periodeLabel }} · Dicetak {{ $generatedAt->translatedFormat('d F Y H:i') }}</div>
        <p class="lead">{{ $generalReport['headline'] }}</p>
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
                    <td class="label-col">Fokus Program</td>
                    <td>{{ $selectedProgram?->nama_program ?? 'Semua Program' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <p class="section-title">2. Ringkasan Kinerja Bulanan</p>
        <table class="summary">
            <tbody>
                <tr>
                    <td>
                        <span class="summary-value">{{ $summary['total_task'] }}</span>
                        <span class="summary-label">Pekerjaan Tercatat</span>
                    </td>
                    <td>
                        <span class="summary-value">{{ $summary['task_selesai'] }}</span>
                        <span class="summary-label">Pekerjaan Selesai</span>
                    </td>
                    <td>
                        <span class="summary-value">{{ $summary['persentase_capaian'] }}%</span>
                        <span class="summary-label">Capaian Bulanan</span>
                    </td>
                    <td>
                        <span class="summary-value">{{ $summary['total_scrum'] }}</span>
                        <span class="summary-label">Aktivitas Harian</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <p class="section-title">3. Poin Capaian Utama</p>
        <ul class="list">
            @foreach($generalReport['achievement_points'] as $point)
            <li>{{ $point }}</li>
            @endforeach
        </ul>
    </div>

    <div class="section">
        <p class="section-title">4. Gambaran Per Program</p>
        @if(collect($generalReport['program_highlights'])->isNotEmpty())
        <table>
            <thead>
                <tr>
                    <th style="width: 28%;">Program</th>
                    <th style="width: 42%;">Ringkasan</th>
                    <th style="width: 10%;">Total</th>
                    <th style="width: 10%;">Selesai</th>
                    <th style="width: 10%;">Capaian</th>
                </tr>
            </thead>
            <tbody>
                @foreach($generalReport['program_highlights'] as $highlight)
                <tr>
                    <td>{{ $highlight['program']->nama_program }}</td>
                    <td>{{ $highlight['narrative'] }}</td>
                    <td>{{ $highlight['task_total'] }}</td>
                    <td>{{ $highlight['task_completed'] }}</td>
                    <td>{{ $highlight['progress'] }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p class="empty">Belum ada data program yang relevan pada periode ini.</p>
        @endif
    </div>

    <div class="section">
        <p class="section-title">5. Aktivitas Utama Selama Bulan Ini</p>
        @if(collect($generalReport['activity_digest'])->isNotEmpty())
        <ul class="list">
            @foreach($generalReport['activity_digest'] as $item)
            <li>{{ $item }}</li>
            @endforeach
        </ul>
        @else
        <p class="empty">Belum ada ringkasan aktivitas pada periode ini.</p>
        @endif
    </div>

    <div class="section">
        <p class="section-title">6. Dampak dan Hasil</p>
        <ul class="list">
            @foreach($generalReport['impact_points'] as $item)
            <li>{{ $item }}</li>
            @endforeach
        </ul>
    </div>

    <div class="section">
        <p class="section-title">7. Kendala Singkat</p>
        <ul class="list">
            @foreach($obstacles as $item)
            <li>{{ $item }}</li>
            @endforeach
        </ul>
    </div>

    <div class="section">
        <p class="section-title">8. Tindak Lanjut</p>
        <ul class="list">
            @foreach($followUps as $item)
            <li>{{ $item }}</li>
            @endforeach
        </ul>
    </div>

    <div class="section">
        <p class="section-title">9. Kesimpulan Umum</p>
        <p class="paragraph">{{ $generalReport['simple_conclusion'] }}</p>
    </div>

    <div class="footer">Kerjao · Laporan Bulanan Umum · {{ $generatedAt->translatedFormat('d F Y H:i') }}</div>
</body>
</html>
