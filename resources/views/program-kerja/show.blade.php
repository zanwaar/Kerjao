@extends('layouts.app')
@section('title', $programKerja->nama_program)
@section('content')

<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('program-kerja.index') }}" class="text-gray-400 hover:text-gray-600">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <h2 class="text-lg font-semibold text-gray-800">{{ $programKerja->nama_program }}</h2>
    <x-badge-status :status="$programKerja->status_program->value">{{ $programKerja->status_program->label() }}</x-badge-status>
    @if(auth()->user()->can('program-kerja.edit') && $programKerja->canBeManagedBy(auth()->user()))
    <a href="{{ route('program-kerja.edit', $programKerja) }}" class="ml-auto text-sm text-indigo-600 hover:underline">Edit</a>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl border border-gray-200 p-5 space-y-3">
        <h3 class="font-medium text-gray-700 text-sm">Informasi Program</h3>
        <dl class="space-y-2 text-sm">
            <div><dt class="text-gray-400">Mulai</dt><dd class="text-gray-800">{{ $programKerja->waktu_mulai->format('d M Y') }}</dd></div>
            <div><dt class="text-gray-400">Selesai</dt><dd class="text-gray-800">{{ $programKerja->waktu_selesai->format('d M Y') }}</dd></div>
            <div><dt class="text-gray-400">Dibuat oleh</dt><dd class="text-gray-800">{{ $programKerja->creator->name }}</dd></div>
            @if($programKerja->deskripsi)
            <div><dt class="text-gray-400">Deskripsi</dt><dd class="text-gray-700">{{ $programKerja->deskripsi }}</dd></div>
            @endif
        </dl>
    </div>

    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-medium text-gray-700">Kegiatan ({{ $programKerja->kegiatan->count() }})</h3>
            @if(auth()->user()->can('kegiatan.create') && $programKerja->canBeManagedBy(auth()->user()))
            <a href="{{ route('kegiatan.create', ['program_kerja_id' => $programKerja->id]) }}" class="text-xs bg-indigo-600 text-white px-3 py-1 rounded-lg hover:bg-indigo-700">+ Tambah</a>
            @endif
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($programKerja->kegiatan as $kegiatan)
            <div class="px-5 py-4">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <a href="{{ route('kegiatan.show', $kegiatan) }}" class="text-sm font-medium text-gray-800 hover:text-indigo-600">{{ $kegiatan->nama_kegiatan }}</a>
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ $kegiatan->waktu_mulai->format('d M') }} — {{ $kegiatan->waktu_selesai->format('d M Y') }}
                            · {{ $kegiatan->task_done_count }}/{{ $kegiatan->tasks_count }} task selesai
                        </p>
                    </div>
                    <x-badge-status :status="$kegiatan->status_kegiatan->value">{{ $kegiatan->status_kegiatan->label() }}</x-badge-status>
                </div>

                @if(auth()->user()->can('task.view-all'))
                <div class="mt-4 space-y-3">
                    @forelse($kegiatan->tasks as $task)
                    <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <a href="{{ route('task.show', $task) }}" class="text-sm font-medium text-gray-800 hover:text-indigo-600">{{ $task->nama_task }}</a>
                                <p class="text-xs text-gray-400 mt-1">{{ $task->assignee?->nama_pegawai ?? 'Belum diassign' }} · Progress {{ $task->progress_persen }}%</p>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <span class="text-xs text-gray-500">{{ $task->daily_scrums_count }} scrum</span>
                                <x-badge-status :status="$task->status->value">{{ $task->status->label() }}</x-badge-status>
                            </div>
                        </div>

                        <div class="mt-3 h-1.5 bg-white rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-500 rounded-full" style="width: {{ $task->progress_persen }}%"></div>
                        </div>

                        <div class="mt-3 space-y-2">
                            @forelse($task->dailyScrums as $scrum)
                            <div class="rounded-lg border border-gray-200 bg-white px-3 py-2">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="text-xs font-medium text-gray-600">{{ $scrum->pegawai->nama_pegawai }}</p>
                                    <span class="text-xs text-gray-400">{{ $scrum->tanggal->format('d M Y') }}</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">{{ $scrum->rencana_kerja_harian }}</p>
                            </div>
                            @empty
                            <p class="text-xs text-gray-400">Belum ada daily scrum pada task ini.</p>
                            @endforelse
                        </div>
                    </div>
                    @empty
                    <div class="rounded-xl border border-dashed border-gray-200 px-4 py-6 text-center text-sm text-gray-400">
                        Belum ada task pada kegiatan ini.
                    </div>
                    @endforelse
                </div>
                @endif
            </div>
            @empty
            <div class="px-5 py-8 text-center text-sm text-gray-400">Belum ada kegiatan</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
