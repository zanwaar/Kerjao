@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@if($canViewAllTasks)
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wide">{{ $selectedPegawai ? 'Pegawai Dipilih' : 'Pegawai Aktif' }}</p>
        <p class="text-2xl font-bold text-indigo-600 mt-1">{{ $selectedPegawai ? $selectedPegawai->nama_pegawai : $totalPegawaiAktif }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Program Aktif</p>
        <p class="text-2xl font-bold text-blue-600 mt-1">{{ $totalProgramAktif }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Task Berjalan</p>
        <p class="text-2xl font-bold text-amber-600 mt-1">{{ $taskOnProgress }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Scrum Tercatat</p>
        <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $scrumTerbaru->count() }}</p>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    <div class="xl:col-span-2 space-y-6">
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="font-semibold text-gray-800">Pantauan Aktivitas Pegawai</h2>
                    <p class="text-xs text-gray-500 mt-1">Ringkasan task aktif, task selesai, dan jejak aktivitas hari ini. Klik baris pegawai untuk membuka detail program, task, dan daily scrum.</p>
                </div>
                <div class="flex items-center gap-3">
                    @if($selectedPegawai)
                    <a href="{{ route('dashboard') }}" class="text-xs text-gray-500 hover:text-indigo-600">Lihat semua</a>
                    @endif
                    <a href="{{ route('pegawai.index') }}" class="text-xs text-indigo-600 hover:underline">Kelola Pegawai</a>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="text-left px-5 py-3 font-medium text-gray-600">Pegawai</th>
                            <th class="text-left px-5 py-3 font-medium text-gray-600">Task Aktif</th>
                            <th class="text-left px-5 py-3 font-medium text-gray-600">Task Selesai</th>
                            <th class="text-left px-5 py-3 font-medium text-gray-600">Scrum Hari Ini</th>
                            <th class="text-left px-5 py-3 font-medium text-gray-600">Aktivitas Hari Ini</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($aktivitasPegawai as $pegawai)
                        @php
                            $isSelectedPegawai = $selectedPegawai?->id === $pegawai->id;
                            $dashboardPegawaiUrl = route('dashboard', ['pegawai_id' => $pegawai->id]);
                        @endphp
                        <tr @class([
                            'transition-colors',
                            'bg-indigo-50/60' => $isSelectedPegawai,
                            'hover:bg-gray-50' => ! $isSelectedPegawai,
                        ])>
                            <td class="px-5 py-3">
                                <a href="{{ $dashboardPegawaiUrl }}" class="group block rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <p class="font-medium {{ $isSelectedPegawai ? 'text-indigo-700' : 'text-gray-800 group-hover:text-indigo-600' }}">{{ $pegawai->nama_pegawai }}</p>
                                    <p class="text-xs mt-0.5 {{ $isSelectedPegawai ? 'text-indigo-500' : 'text-gray-400' }}">{{ $pegawai->jabatan }} · {{ $pegawai->unit_kerja }}</p>
                                </a>
                            </td>
                            <td class="px-5 py-3">
                                <a href="{{ $dashboardPegawaiUrl }}" class="block text-gray-700 {{ $isSelectedPegawai ? 'font-semibold text-indigo-700' : 'hover:text-indigo-600' }}">{{ $pegawai->task_aktif_count }}</a>
                            </td>
                            <td class="px-5 py-3">
                                <a href="{{ $dashboardPegawaiUrl }}" class="block text-gray-700 {{ $isSelectedPegawai ? 'font-semibold text-indigo-700' : 'hover:text-indigo-600' }}">{{ $pegawai->task_selesai_count }}</a>
                            </td>
                            <td class="px-5 py-3">
                                <a href="{{ $dashboardPegawaiUrl }}" class="block text-gray-700 {{ $isSelectedPegawai ? 'font-semibold text-indigo-700' : 'hover:text-indigo-600' }}">{{ $pegawai->scrum_hari_ini_count }}</a>
                            </td>
                            <td class="px-5 py-3">
                                <a href="{{ $dashboardPegawaiUrl }}" class="block rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <div class="flex flex-wrap gap-2 text-xs {{ $isSelectedPegawai ? 'text-indigo-600' : 'text-gray-500' }}">
                                        <span class="rounded-full px-2 py-0.5 {{ $isSelectedPegawai ? 'bg-indigo-100' : 'bg-gray-100' }}">Bukti {{ $pegawai->bukti_hari_ini_count }}</span>
                                        <span class="rounded-full px-2 py-0.5 {{ $isSelectedPegawai ? 'bg-indigo-100' : 'bg-gray-100' }}">GitHub {{ $pegawai->github_hari_ini_count }}</span>
                                        <span class="rounded-full px-2 py-0.5 {{ $isSelectedPegawai ? 'bg-indigo-100' : 'bg-gray-100' }}">WakaTime {{ $pegawai->wakatime_hari_ini_count }}</span>
                                    </div>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-gray-400">Belum ada data pegawai aktif.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($selectedPegawai)
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="font-semibold text-gray-800">Ringkasan {{ $selectedPegawai->nama_pegawai }}</h2>
                <p class="text-xs text-gray-500 mt-1">Program, task, dan progres harian pegawai terpilih langsung dari dashboard.</p>
            </div>

            <div class="px-5 py-5 space-y-5">
                <div>
                    <h3 class="text-sm font-medium text-gray-700 mb-3">Program Terkait</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @forelse($programMonitor as $program)
                        @php
                            $programTasks = $program->kegiatan->flatMap->tasks;
                            $programAverageProgress = (int) round($programTasks->avg('progress_persen') ?? 0);
                        @endphp
                        <a href="{{ route('program-kerja.show', $program) }}" class="rounded-xl border border-gray-200 p-4 hover:border-indigo-200 hover:bg-indigo-50/40 transition-colors">
                            <div class="flex items-center justify-between gap-3">
                                <p class="font-medium text-gray-800">{{ $program->nama_program }}</p>
                                <x-badge-status :status="$program->status_program->value">{{ $program->status_program->label() }}</x-badge-status>
                            </div>
                            <p class="text-xs text-gray-400 mt-1">{{ $programTasks->count() }} task untuk pegawai ini</p>
                            <div class="mt-3 h-2 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-indigo-500 rounded-full" style="width: {{ $programAverageProgress }}%"></div>
                            </div>
                        </a>
                        @empty
                        <div class="md:col-span-2 rounded-xl border border-dashed border-gray-200 px-4 py-6 text-center text-sm text-gray-400">
                            Pegawai ini belum punya program yang terkait task.
                        </div>
                        @endforelse
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-700 mb-3">Task Pegawai</h3>
                    <div class="space-y-3">
                        @forelse($selectedPegawaiTasks as $task)
                        <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <a href="{{ route('task.show', $task) }}" class="text-sm font-medium text-gray-800 hover:text-indigo-600">{{ $task->nama_task }}</a>
                                    <p class="text-xs text-gray-400 mt-1">{{ $task->kegiatan->programKerja->nama_program }} · {{ $task->kegiatan->nama_kegiatan }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-gray-500">{{ $task->daily_scrums_count }} scrum</span>
                                    <x-badge-status :status="$task->status->value">{{ $task->status->label() }}</x-badge-status>
                                </div>
                            </div>
                            <div class="mt-3 h-1.5 bg-white rounded-full overflow-hidden">
                                <div class="h-full bg-indigo-500 rounded-full" style="width: {{ $task->progress_persen }}%"></div>
                            </div>
                        </div>
                        @empty
                        <div class="rounded-xl border border-dashed border-gray-200 px-4 py-6 text-center text-sm text-gray-400">
                            Belum ada task untuk pegawai yang dipilih.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="font-semibold text-gray-800">Total Program</h2>
                    <p class="text-xs text-gray-500 mt-1">Admin memantau progres program dari satu pintu.</p>
                </div>
                <a href="{{ route('program-kerja.index') }}" class="text-xs text-indigo-600 hover:underline">Lihat semua program</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-5">
                @forelse($programMonitor as $program)
                @php
                    $programTasks = $program->kegiatan->flatMap->tasks;
                    $programTaskCount = $programTasks->count();
                    $programDoneCount = $programTasks->where('status', \App\Enums\StatusTask::Done)->count();
                    $programAverageProgress = (int) round($programTasks->avg('progress_persen') ?? 0);
                @endphp
                <a href="{{ route('program-kerja.show', $program) }}" class="rounded-xl border border-gray-200 p-4 hover:border-indigo-200 hover:bg-indigo-50/40 transition-colors">
                    <div class="flex items-center justify-between gap-3">
                        <p class="font-medium text-gray-800">{{ $program->nama_program }}</p>
                        <x-badge-status :status="$program->status_program->value">{{ $program->status_program->label() }}</x-badge-status>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">{{ $program->kegiatan->count() }} kegiatan · {{ $programTaskCount }} task</p>
                    <div class="mt-4 flex items-center justify-between text-sm">
                        <span class="text-gray-500">Selesai {{ $programDoneCount }}/{{ $programTaskCount }}</span>
                        <span class="font-semibold text-indigo-600">{{ $programAverageProgress }}%</span>
                    </div>
                    <div class="mt-2 h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-indigo-500 rounded-full" style="width: {{ $programAverageProgress }}%"></div>
                    </div>
                </a>
                @empty
                <div class="md:col-span-2 rounded-xl border border-dashed border-gray-200 p-8 text-center text-sm text-gray-400">
                    Belum ada program untuk dipantau.
                </div>
                @endforelse
            </div>
        </div>
        @endif
    </div>

    <div class="space-y-6">
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-semibold text-gray-800">{{ $selectedPegawai ? 'Daily Scrum Pegawai' : 'Daily Scrum Terbaru' }}</h2>
                <a href="{{ route('laporan.index') }}" class="text-xs text-indigo-600 hover:underline">Laporan</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($scrumTerbaru as $scrum)
                <div class="px-5 py-3">
                    <div class="flex items-center justify-between gap-3">
                        <p class="text-sm font-medium text-gray-800">{{ $scrum->pegawai->nama_pegawai }}</p>
                        <span class="text-xs text-gray-400">{{ $scrum->tanggal->format('d M Y') }}</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">{{ $scrum->task->kegiatan->programKerja->nama_program }} · {{ $scrum->task->nama_task }}</p>
                    <p class="text-sm text-gray-600 mt-2 line-clamp-3">{{ $scrum->rencana_kerja_harian }}</p>
                </div>
                @empty
                <div class="px-5 py-8 text-center text-sm text-gray-400">Belum ada daily scrum terbaru.</div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-semibold text-gray-800">{{ $selectedPegawai ? 'Task Terlambat Pegawai' : 'Task Terlambat' }}</h2>
                <span class="text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded-full font-medium">{{ $taskOverdue->count() }}</span>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($taskOverdue as $task)
                <div class="px-5 py-3">
                    <a href="{{ route('program-kerja.show', $task->kegiatan->programKerja) }}" class="text-sm font-medium text-gray-800 hover:text-indigo-600">{{ $task->nama_task }}</a>
                    <p class="text-xs text-gray-400 mt-1">{{ $task->kegiatan->programKerja->nama_program }} · {{ $task->assignee?->nama_pegawai ?? '-' }}</p>
                    <p class="text-xs text-red-600 font-medium mt-2">Due {{ $task->due_date?->format('d M Y') }}</p>
                </div>
                @empty
                <div class="px-5 py-8 text-center text-sm text-gray-400">Tidak ada task overdue.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@else
{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wide">{{ $canViewAllTasks ? 'Program Aktif' : 'Program Saya' }}</p>
        <p class="text-2xl font-bold text-indigo-600 mt-1">{{ $totalProgramAktif }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wide">{{ $canViewAllTasks ? 'Kegiatan Aktif' : 'Kegiatan Saya' }}</p>
        <p class="text-2xl font-bold text-blue-600 mt-1">{{ $totalKegiatanAktif }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wide">{{ $canViewAllTasks ? 'Total Task' : 'Task Saya' }}</p>
        <p class="text-2xl font-bold text-gray-700 mt-1">{{ $totalTask }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Task Selesai</p>
        <p class="text-2xl font-bold text-green-600 mt-1">{{ $taskSelesai }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wide">On Progress</p>
        <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $taskOnProgress }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Task Overdue --}}
    <div class="bg-white rounded-xl border border-gray-200">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-semibold text-gray-800">{{ $canViewAllTasks ? 'Task Overdue' : 'Task Saya Terlambat' }}</h2>
            <span class="text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded-full font-medium">{{ $taskOverdue->count() }}</span>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($taskOverdue as $task)
            <div class="px-5 py-3 flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <a href="{{ route('task.show', $task) }}" class="text-sm font-medium text-gray-800 hover:text-indigo-600 truncate block">
                        {{ $task->nama_task }}
                    </a>
                    <p class="text-xs text-gray-400 mt-0.5">
                        {{ $task->kegiatan->programKerja->nama_program }} · {{ $task->kegiatan->nama_kegiatan }}
                        @if($canViewAllTasks && $task->assignee)
                        · {{ $task->assignee->nama_pegawai }}
                        @endif
                    </p>
                </div>
                <span class="shrink-0 text-xs text-red-600 font-medium">{{ $task->due_date?->format('d M') }}</span>
            </div>
            @empty
            <div class="px-5 py-8 text-center text-sm text-gray-400">Tidak ada task overdue</div>
            @endforelse
        </div>
    </div>

    {{-- Kanan: Task Saya + Scrum hari ini --}}
    <div class="space-y-6">
        {{-- Task Saya --}}
        @if($taskSaya->isNotEmpty())
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-semibold text-gray-800">Task Saya</h2>
                <a href="{{ route('task.saya') }}" class="text-xs text-indigo-600 hover:underline">Lihat semua</a>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach($taskSaya as $task)
                <div class="px-5 py-3">
                    <div class="flex items-center justify-between gap-2 mb-1">
                        <a href="{{ route('task.show', $task) }}" class="text-sm font-medium text-gray-800 hover:text-indigo-600 truncate">
                            {{ $task->nama_task }}
                        </a>
                        <span class="shrink-0 text-xs px-2 py-0.5 rounded-full
                            {{ $task->prioritas->value === 'high' ? 'bg-red-100 text-red-700' : ($task->prioritas->value === 'medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-600') }}">
                            {{ $task->prioritas->label() }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-500 rounded-full" style="width: {{ $task->progress_persen }}%"></div>
                        </div>
                        <span class="text-xs text-gray-400 shrink-0">{{ $task->progress_persen }}%</span>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">{{ $task->kegiatan->programKerja->nama_program }} · {{ $task->kegiatan->nama_kegiatan }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Scrum Hari Ini --}}
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-semibold text-gray-800">Scrum Hari Ini</h2>
                <a href="{{ route('daily-scrum.create') }}" class="text-xs bg-indigo-600 text-white px-3 py-1 rounded-lg hover:bg-indigo-700">+ Tambah</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($scrumHariIni as $scrum)
                <div class="px-5 py-3">
                    <p class="text-sm font-medium text-gray-800 truncate">{{ $scrum->task->nama_task }}</p>
                    <p class="text-xs text-gray-500 mt-0.5 line-clamp-2">{{ $scrum->rencana_kerja_harian }}</p>
                </div>
                @empty
                <div class="px-5 py-8 text-center">
                    <p class="text-sm text-gray-400">Belum ada scrum hari ini</p>
                    <a href="{{ route('daily-scrum.create') }}" class="mt-2 inline-block text-sm text-indigo-600 hover:underline">Isi sekarang</a>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endif
@endsection
