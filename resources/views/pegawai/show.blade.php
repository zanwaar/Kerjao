@extends('layouts.app')
@section('title', $pegawai->nama_pegawai)
@section('content')

<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('pegawai.index') }}" class="text-gray-400 hover:text-gray-600">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <h2 class="text-lg font-semibold text-gray-800">{{ $pegawai->nama_pegawai }}</h2>
    <x-badge-status :status="$pegawai->status_pegawai->value">{{ $pegawai->status_pegawai->label() }}</x-badge-status>
    @can('pegawai.edit')
    <a href="{{ route('pegawai.edit', $pegawai) }}" class="ml-auto text-sm text-indigo-600 hover:underline">Edit</a>
    @endcan
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl border border-gray-200 p-5 space-y-3">
        <h3 class="font-medium text-gray-700 text-sm">Informasi Pegawai</h3>
        <dl class="space-y-2 text-sm">
            <div><dt class="text-gray-400">NIP</dt><dd class="text-gray-800 font-medium">{{ $pegawai->nip ?? '-' }}</dd></div>
            <div><dt class="text-gray-400">Jabatan</dt><dd class="text-gray-800">{{ $pegawai->jabatan }}</dd></div>
            <div><dt class="text-gray-400">Unit Kerja</dt><dd class="text-gray-800">{{ $pegawai->unit_kerja }}</dd></div>
            @if($pegawai->user)
            <div><dt class="text-gray-400">Email</dt><dd class="text-gray-800">{{ $pegawai->user->email }}</dd></div>
            @endif
            @if($pegawai->github_username)
            <div><dt class="text-gray-400">GitHub</dt><dd class="text-indigo-600">@{{ $pegawai->github_username }}</dd></div>
            @endif
        </dl>
    </div>

    <div class="lg:col-span-2 space-y-6">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <p class="text-xs text-gray-500 uppercase tracking-wide">Program</p>
                <p class="text-2xl font-bold text-indigo-600 mt-1">{{ $summary['program_count'] }}</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <p class="text-xs text-gray-500 uppercase tracking-wide">Total Task</p>
                <p class="text-2xl font-bold text-blue-600 mt-1">{{ $summary['task_count'] }}</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <p class="text-xs text-gray-500 uppercase tracking-wide">Task Selesai</p>
                <p class="text-2xl font-bold text-green-600 mt-1">{{ $summary['task_done_count'] }}</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <p class="text-xs text-gray-500 uppercase tracking-wide">Daily Scrum</p>
                <p class="text-2xl font-bold text-amber-600 mt-1">{{ $summary['daily_scrum_count'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-medium text-gray-700">Program yang Dikerjakan</h3>
                <span class="text-xs text-gray-400">{{ $programs->count() }} program</span>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($programs as $program)
                <div class="px-5 py-4">
                    <div class="flex items-center justify-between gap-3">
                        <a href="{{ route('program-kerja.show', $program) }}" class="text-sm font-medium text-gray-800 hover:text-indigo-600">{{ $program->nama_program }}</a>
                        <x-badge-status :status="$program->status_program->value">{{ $program->status_program->label() }}</x-badge-status>
                    </div>
                    <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($program->kegiatan as $kegiatan)
                        <div class="rounded-lg border border-gray-100 bg-gray-50 p-3">
                            <p class="text-sm font-medium text-gray-800">{{ $kegiatan->nama_kegiatan }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $kegiatan->task_done_count }}/{{ $kegiatan->tasks_count }} task selesai</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @empty
                <div class="px-5 py-8 text-center text-sm text-gray-400">Pegawai ini belum punya program yang terkait task.</div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-medium text-gray-700">Task Pegawai</h3>
                <span class="text-xs text-gray-400">{{ $tasks->count() }} task</span>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($tasks as $task)
                <div class="px-5 py-4">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <a href="{{ route('task.show', $task) }}" class="text-sm font-medium text-gray-800 hover:text-indigo-600">{{ $task->nama_task }}</a>
                            <p class="text-xs text-gray-400">{{ $task->kegiatan->programKerja->nama_program }} · {{ $task->kegiatan->nama_kegiatan }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-500">{{ $task->progress_persen }}%</span>
                            <x-badge-status :status="$task->status->value">{{ $task->status->label() }}</x-badge-status>
                        </div>
                    </div>

                    <div class="mt-3 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-indigo-500 rounded-full" style="width: {{ $task->progress_persen }}%"></div>
                    </div>

                    <div class="mt-3 space-y-2">
                        @forelse($task->dailyScrums as $scrum)
                        <div class="rounded-lg border border-gray-100 bg-gray-50 px-3 py-2">
                            <div class="flex items-center justify-between gap-3">
                                <p class="text-xs font-medium text-gray-600">{{ $scrum->tanggal->format('d M Y') }}</p>
                                <span class="text-xs text-gray-400">{{ $scrum->pegawai->nama_pegawai }}</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">{{ $scrum->rencana_kerja_harian }}</p>
                        </div>
                        @empty
                        <p class="text-xs text-gray-400">Belum ada daily scrum pada task ini.</p>
                        @endforelse
                    </div>
                </div>
                @empty
                <div class="px-5 py-6 text-center text-sm text-gray-400">Tidak ada task</div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-medium text-gray-700">Daily Scrum Terbaru</h3>
                <span class="text-xs text-gray-400">{{ $dailyScrums->count() }} entri</span>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($dailyScrums as $scrum)
                <div class="px-5 py-3">
                    <div class="flex items-center justify-between gap-3">
                        <p class="text-sm font-medium text-gray-800">{{ $scrum->task->nama_task }}</p>
                        <span class="text-xs text-gray-400">{{ $scrum->tanggal->format('d M Y') }}</span>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">{{ $scrum->task->kegiatan->programKerja->nama_program }} · {{ $scrum->task->kegiatan->nama_kegiatan }}</p>
                    <p class="text-sm text-gray-600 mt-2">{{ $scrum->rencana_kerja_harian }}</p>
                </div>
                @empty
                <div class="px-5 py-6 text-center text-sm text-gray-400">Belum ada daily scrum</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
