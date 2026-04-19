<div class="space-y-6">
    <section class="bg-white rounded-xl border border-gray-200 p-6">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600">Identitas Laporan</p>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4 mt-4">
            <div class="rounded-xl border border-gray-200 p-4 bg-gray-50">
                <p class="text-xs text-gray-500">Nama Pegawai</p>
                <p class="text-sm font-semibold text-gray-800 mt-1">{{ $selectedPegawai?->nama_pegawai ?? 'Semua Pegawai' }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 p-4 bg-gray-50">
                <p class="text-xs text-gray-500">Jabatan</p>
                <p class="text-sm font-semibold text-gray-800 mt-1">{{ $selectedPegawai?->jabatan ?? '-' }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 p-4 bg-gray-50">
                <p class="text-xs text-gray-500">Unit Kerja</p>
                <p class="text-sm font-semibold text-gray-800 mt-1">{{ $selectedPegawai?->unit_kerja ?? '-' }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 p-4 bg-gray-50">
                <p class="text-xs text-gray-500">Periode</p>
                <p class="text-sm font-semibold text-gray-800 mt-1">{{ $periodeLabel }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 p-4 bg-gray-50">
                <p class="text-xs text-gray-500">Tanggal Lapor</p>
                <p class="text-sm font-semibold text-gray-800 mt-1">{{ $generatedAt->translatedFormat('d F Y') }}</p>
            </div>
        </div>
    </section>

    <section class="bg-white rounded-xl border border-gray-200 p-6">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600">Ringkasan Kinerja Bulanan</p>
        <div class="grid grid-cols-2 lg:grid-cols-6 gap-4 mt-4">
            <div class="rounded-xl border border-gray-200 p-4">
                <p class="text-xs text-gray-500 uppercase tracking-wide">Total Task</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $summary['total_task'] }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 p-4">
                <p class="text-xs text-gray-500 uppercase tracking-wide">Task Selesai</p>
                <p class="text-2xl font-bold text-green-600 mt-1">{{ $summary['task_selesai'] }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 p-4">
                <p class="text-xs text-gray-500 uppercase tracking-wide">On Progress</p>
                <p class="text-2xl font-bold text-amber-600 mt-1">{{ $summary['task_on_progress'] }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 p-4">
                <p class="text-xs text-gray-500 uppercase tracking-wide">Tidak Selesai</p>
                <p class="text-2xl font-bold text-rose-600 mt-1">{{ $summary['task_tidak_selesai'] }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 p-4">
                <p class="text-xs text-gray-500 uppercase tracking-wide">Capaian</p>
                <p class="text-2xl font-bold text-indigo-600 mt-1">{{ $summary['persentase_capaian'] }}%</p>
            </div>
            <div class="rounded-xl border border-gray-200 p-4">
                <p class="text-xs text-gray-500 uppercase tracking-wide">Hari Kerja</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $summary['total_hari_kerja'] }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-4">
            <div class="rounded-xl border border-gray-200 p-4 bg-slate-50">
                <p class="text-sm font-semibold text-gray-800">WakaTime</p>
                <p class="text-sm text-gray-600 mt-2">Total Jam Kerja (Coding): <span class="font-semibold text-gray-800">{{ number_format($summary['total_jam_kerja'], 1) }} jam</span></p>
                <p class="text-sm text-gray-600 mt-1">Rata-rata per hari: <span class="font-semibold text-gray-800">{{ number_format($summary['rata_rata_jam_kerja'], 1) }} jam</span></p>
            </div>
            <div class="rounded-xl border border-gray-200 p-4 bg-slate-50">
                <p class="text-sm font-semibold text-gray-800">GitHub</p>
                <p class="text-sm text-gray-600 mt-2">Total Commit: <span class="font-semibold text-gray-800">{{ $summary['total_commit'] }}</span></p>
                <p class="text-sm text-gray-600 mt-1">Pull Request: <span class="font-semibold text-gray-800">{{ $summary['total_pull_request'] }}</span></p>
                <p class="text-sm text-gray-600 mt-1">Issue Tercatat: <span class="font-semibold text-gray-800">{{ $summary['total_issue'] }}</span></p>
            </div>
        </div>
    </section>

    <section class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600">Rincian Program & Kegiatan</p>
        </div>

        @forelse($programReports as $programReport)
        <div class="px-6 py-5 border-b border-gray-100 last:border-b-0">
            <div class="flex items-center justify-between gap-3 mb-4">
                <div>
                    <p class="text-lg font-semibold text-gray-800">{{ $programReport['program']->nama_program }}</p>
                    <p class="text-sm text-gray-500">{{ $programReport['program']->status_program->label() }}</p>
                </div>
                <x-badge-status :status="$programReport['program']->status_program->value">{{ $programReport['program']->status_program->label() }}</x-badge-status>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-y border-gray-100">
                        <tr>
                            <th class="text-left px-4 py-3 font-medium text-gray-600 w-12">No</th>
                            <th class="text-left px-4 py-3 font-medium text-gray-600">Kegiatan</th>
                            <th class="text-left px-4 py-3 font-medium text-gray-600">Target</th>
                            <th class="text-left px-4 py-3 font-medium text-gray-600">Realisasi</th>
                            <th class="text-left px-4 py-3 font-medium text-gray-600">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($programReport['kegiatan_rows'] as $row)
                        <tr>
                            <td class="px-4 py-3 text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3"><p class="font-medium text-gray-800">{{ $row['kegiatan']->nama_kegiatan }}</p></td>
                            <td class="px-4 py-3 text-gray-600">{{ $row['target'] }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $row['realisasi'] }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $row['status'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @empty
        <div class="px-6 py-12 text-center text-sm text-gray-400">Tidak ada data program dan kegiatan pada periode ini.</div>
        @endforelse
    </section>

    <section class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600">Rincian Task</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-4 py-3 font-medium text-gray-600 w-12">No</th>
                        <th class="text-left px-4 py-3 font-medium text-gray-600">Task</th>
                        <th class="text-left px-4 py-3 font-medium text-gray-600">Kegiatan</th>
                        <th class="text-left px-4 py-3 font-medium text-gray-600">Assigned</th>
                        <th class="text-left px-4 py-3 font-medium text-gray-600">Status</th>
                        <th class="text-left px-4 py-3 font-medium text-gray-600">Progress</th>
                        <th class="text-left px-4 py-3 font-medium text-gray-600">Due Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($tasks as $task)
                    <tr>
                        <td class="px-4 py-3 text-gray-500">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3">
                            <p class="font-medium text-gray-800">{{ $task->nama_task }}</p>
                            @if($task->deskripsi_task)
                            <p class="text-xs text-gray-500 mt-1">{{ \Illuminate\Support\Str::of($task->deskripsi_task)->squish()->limit(90) }}</p>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-600">
                            <p>{{ $task->kegiatan->nama_kegiatan }}</p>
                            <p class="text-xs text-gray-400">{{ $task->kegiatan->programKerja->nama_program }}</p>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $task->assignee?->nama_pegawai ?? '-' }}</td>
                        <td class="px-4 py-3"><x-badge-status :status="$task->status->value">{{ $task->status->label() }}</x-badge-status></td>
                        <td class="px-4 py-3 text-gray-600">{{ $task->progress_persen }}%</td>
                        <td class="px-4 py-3 text-gray-600 whitespace-nowrap">{{ $task->due_date?->translatedFormat('d M Y') ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-4 py-12 text-center text-sm text-gray-400">Tidak ada task pada periode ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600">Ringkasan Aktivitas Harian</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-4 py-3 font-medium text-gray-600">Tanggal</th>
                        <th class="text-left px-4 py-3 font-medium text-gray-600">Task</th>
                        <th class="text-left px-4 py-3 font-medium text-gray-600">Rencana</th>
                        <th class="text-left px-4 py-3 font-medium text-gray-600">Realisasi</th>
                        <th class="text-left px-4 py-3 font-medium text-gray-600">Kendala</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($scrums as $scrum)
                    <tr>
                        <td class="px-4 py-3 text-gray-600 whitespace-nowrap">{{ $scrum->tanggal->translatedFormat('d M Y') }}</td>
                        <td class="px-4 py-3 text-gray-600">
                            <p class="font-medium text-gray-800">{{ $scrum->task->nama_task }}</p>
                            <p class="text-xs text-gray-400">{{ $scrum->pegawai->nama_pegawai }}</p>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $scrum->rencana_kerja_harian }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $scrum->realisasi ?: '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $scrum->potensi_risiko ?: '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-4 py-12 text-center text-sm text-gray-400">Tidak ada daily scrum pada periode ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="bg-white rounded-xl border border-gray-200 p-6">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600">Bukti Pencapaian</p>
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 mt-4">
            <div class="rounded-xl border border-gray-200 p-4">
                <p class="text-sm font-semibold text-gray-800">Dokumen / Output</p>
                <div class="mt-3 space-y-3 text-sm text-gray-600">
                    @forelse($evidence['bukti_aktivitas']->take(5) as $bukti)
                    <div class="border border-gray-100 rounded-lg p-3">
                        <p class="font-medium text-gray-800">{{ $bukti->jenis_bukti->label() }}</p>
                        <p class="mt-1 break-all">{{ $bukti->sumber_bukti }}</p>
                        @if($bukti->keterangan)
                        <p class="mt-1 text-xs text-gray-500">{{ $bukti->keterangan }}</p>
                        @endif
                    </div>
                    @empty
                    <p class="text-gray-400">Belum ada bukti aktivitas pada periode ini.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-xl border border-gray-200 p-4">
                <p class="text-sm font-semibold text-gray-800">GitHub</p>
                <div class="mt-3 space-y-2 text-sm text-gray-600">
                    <p>Repo: <span class="font-medium text-gray-800">{{ $evidence['repos']->isNotEmpty() ? $evidence['repos']->join(', ') : '-' }}</span></p>
                    <p>PR Tercatat: <span class="font-medium text-gray-800">{{ $summary['total_pull_request'] }}</span></p>
                    <p>Commit Penting:</p>
                    <div class="space-y-2">
                        @forelse($evidence['github_activities']->take(5) as $activity)
                        <div class="border border-gray-100 rounded-lg p-3">
                            <p class="font-medium text-gray-800">{{ $activity->repo_name }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $activity->commit_hash ? substr($activity->commit_hash, 0, 7) : 'commit' }} · {{ $activity->commit_time?->translatedFormat('d M Y H:i') ?? '-' }}</p>
                            <p class="mt-1">{{ $activity->commit_message ?: ($activity->pr_link ?: '-') }}</p>
                        </div>
                        @empty
                        <p class="text-gray-400">Tidak ada aktivitas GitHub pada periode ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-gray-200 p-4">
                <p class="text-sm font-semibold text-gray-800">WakaTime</p>
                <div class="mt-3 space-y-2 text-sm text-gray-600">
                    <p>Total durasi kerja: <span class="font-medium text-gray-800">{{ number_format($summary['total_jam_kerja'], 1) }} jam</span></p>
                    <p>Project yang dikerjakan:</p>
                    <div class="space-y-2">
                        @forelse($evidence['project_durations'] as $project => $duration)
                        <div class="flex items-center justify-between gap-3 border border-gray-100 rounded-lg px-3 py-2">
                            <span class="text-gray-700">{{ $project }}</span>
                            <span class="font-medium text-gray-800">{{ number_format($duration, 1) }} jam</span>
                        </div>
                        @empty
                        <p class="text-gray-400">Tidak ada data WakaTime pada periode ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white rounded-xl border border-gray-200 p-6">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600">Analisis Capaian</p>
        <div class="mt-4 space-y-3 text-sm text-gray-700">
            @foreach($analysis as $item)
            <p>{{ $item }}</p>
            @endforeach
        </div>
    </section>

    <section class="bg-white rounded-xl border border-gray-200 p-6">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600">Kendala dan Permasalahan</p>
        <div class="mt-4 space-y-2">
            @foreach($obstacles as $item)
            <div class="flex items-start gap-3 text-sm text-gray-700">
                <span class="mt-1.5 size-2 rounded-full bg-rose-400 shrink-0"></span>
                <p>{{ $item }}</p>
            </div>
            @endforeach
        </div>
    </section>

    <section class="bg-white rounded-xl border border-gray-200 p-6">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600">Rencana Tindak Lanjut</p>
        <div class="mt-4 space-y-2">
            @foreach($followUps as $item)
            <div class="flex items-start gap-3 text-sm text-gray-700">
                <span class="mt-1.5 size-2 rounded-full bg-emerald-400 shrink-0"></span>
                <p>{{ $item }}</p>
            </div>
            @endforeach
        </div>
    </section>

    <section class="bg-white rounded-xl border border-gray-200 p-6">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600">Kesimpulan</p>
        <p class="mt-4 text-sm leading-7 text-gray-700">{{ $conclusion }}</p>
    </section>
</div>
