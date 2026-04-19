<div class="space-y-6">
    <section class="bg-linear-to-br from-blue-50 to-white rounded-2xl border border-blue-100 p-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div class="max-w-3xl">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-600">Mode Umum</p>
                <h2 class="mt-2 text-2xl font-semibold text-slate-900">Ringkasan capaian kerja yang lebih mudah dipahami</h2>
                <p class="mt-3 text-sm leading-7 text-slate-600">{{ $generalReport['headline'] }}</p>
            </div>
            <div class="grid grid-cols-2 gap-3 min-w-72">
                <div class="rounded-xl bg-white border border-blue-100 p-4">
                    <p class="text-xs text-slate-500">Nama Pegawai</p>
                    <p class="mt-1 font-semibold text-slate-900">{{ $selectedPegawai?->nama_pegawai ?? 'Semua Pegawai' }}</p>
                </div>
                <div class="rounded-xl bg-white border border-blue-100 p-4">
                    <p class="text-xs text-slate-500">Periode</p>
                    <p class="mt-1 font-semibold text-slate-900">{{ $periodeLabel }}</p>
                </div>
                <div class="rounded-xl bg-white border border-blue-100 p-4">
                    <p class="text-xs text-slate-500">Program</p>
                    <p class="mt-1 font-semibold text-slate-900">{{ $selectedProgram?->nama_program ?? 'Beragam Program' }}</p>
                </div>
                <div class="rounded-xl bg-white border border-blue-100 p-4">
                    <p class="text-xs text-slate-500">Tanggal Lapor</p>
                    <p class="mt-1 font-semibold text-slate-900">{{ $generatedAt->translatedFormat('d F Y') }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="grid grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <p class="text-xs uppercase tracking-wide text-slate-500">Pekerjaan Tercatat</p>
            <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $summary['total_task'] }}</p>
            <p class="mt-2 text-sm text-slate-500">Total pekerjaan yang dipantau selama periode ini.</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <p class="text-xs uppercase tracking-wide text-slate-500">Pekerjaan Selesai</p>
            <p class="mt-2 text-3xl font-semibold text-emerald-600">{{ $summary['task_selesai'] }}</p>
            <p class="mt-2 text-sm text-slate-500">Bagian pekerjaan yang sudah tuntas dikerjakan.</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <p class="text-xs uppercase tracking-wide text-slate-500">Capaian</p>
            <p class="mt-2 text-3xl font-semibold text-blue-600">{{ $summary['persentase_capaian'] }}%</p>
            <p class="mt-2 text-sm text-slate-500">Gambaran umum tingkat penyelesaian target bulanan.</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <p class="text-xs uppercase tracking-wide text-slate-500">Aktivitas Harian</p>
            <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $summary['total_scrum'] }}</p>
            <p class="mt-2 text-sm text-slate-500">Catatan aktivitas yang mendukung progres pekerjaan.</p>
        </div>
    </section>

    <section class="bg-white rounded-2xl border border-slate-200 p-6">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-600">Poin Capaian Utama</p>
        <div class="mt-4 grid gap-3">
            @foreach($generalReport['achievement_points'] as $point)
            <div class="flex items-start gap-3 rounded-xl border border-slate-100 bg-slate-50 px-4 py-3">
                <span class="mt-1 size-2 rounded-full bg-blue-500 shrink-0"></span>
                <p class="text-sm text-slate-700">{{ $point }}</p>
            </div>
            @endforeach
        </div>
    </section>

    <section class="bg-white rounded-2xl border border-slate-200 p-6">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-600">Gambaran Per Program</p>
        <div class="mt-4 grid gap-4">
            @forelse($generalReport['program_highlights'] as $highlight)
            <div class="rounded-2xl border border-slate-100 p-5">
                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">{{ $highlight['program']->nama_program }}</h3>
                        <p class="mt-2 text-sm leading-7 text-slate-600">{{ $highlight['narrative'] }}</p>
                    </div>
                    <div class="grid grid-cols-3 gap-3 min-w-64">
                        <div class="rounded-xl bg-slate-50 px-3 py-3 text-center">
                            <p class="text-xs text-slate-500">Total</p>
                            <p class="mt-1 font-semibold text-slate-900">{{ $highlight['task_total'] }}</p>
                        </div>
                        <div class="rounded-xl bg-slate-50 px-3 py-3 text-center">
                            <p class="text-xs text-slate-500">Selesai</p>
                            <p class="mt-1 font-semibold text-emerald-600">{{ $highlight['task_completed'] }}</p>
                        </div>
                        <div class="rounded-xl bg-slate-50 px-3 py-3 text-center">
                            <p class="text-xs text-slate-500">Progres</p>
                            <p class="mt-1 font-semibold text-blue-600">{{ $highlight['progress'] }}%</p>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="rounded-xl border border-dashed border-slate-200 px-4 py-10 text-center text-sm text-slate-400">Belum ada data program pada periode ini.</div>
            @endforelse
        </div>
    </section>

    <section class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-slate-200 p-6">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-600">Aktivitas Utama Selama Bulan Ini</p>
            <div class="mt-4 space-y-3">
                @forelse($generalReport['activity_digest'] as $item)
                <div class="rounded-xl border border-slate-100 bg-slate-50 px-4 py-3 text-sm text-slate-700">{{ $item }}</div>
                @empty
                <p class="text-sm text-slate-400">Belum ada ringkasan aktivitas pada periode ini.</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-600">Dampak dan Hasil</p>
            <div class="mt-4 space-y-3">
                @foreach($generalReport['impact_points'] as $item)
                <div class="rounded-xl border border-slate-100 bg-slate-50 px-4 py-3 text-sm text-slate-700">{{ $item }}</div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-slate-200 p-6">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-600">Kendala Singkat</p>
            <div class="mt-4 space-y-2">
                @foreach($obstacles as $item)
                <div class="flex items-start gap-3 text-sm text-slate-700">
                    <span class="mt-1.5 size-2 rounded-full bg-rose-400 shrink-0"></span>
                    <p>{{ $item }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-600">Tindak Lanjut</p>
            <div class="mt-4 space-y-2">
                @foreach($followUps as $item)
                <div class="flex items-start gap-3 text-sm text-slate-700">
                    <span class="mt-1.5 size-2 rounded-full bg-emerald-400 shrink-0"></span>
                    <p>{{ $item }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-slate-900 text-white rounded-2xl p-6">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-200">Kesimpulan Umum</p>
        <p class="mt-4 text-sm leading-7 text-slate-100">{{ $generalReport['simple_conclusion'] }}</p>
    </section>
</div>
