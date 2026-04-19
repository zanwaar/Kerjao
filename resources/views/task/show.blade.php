@extends('layouts.app')
@section('title', $task->nama_task)
@section('content')

<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('task.index') }}" class="text-gray-400 hover:text-gray-600">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <h2 class="text-lg font-semibold text-gray-800 truncate">{{ $task->nama_task }}</h2>
    <x-badge-status :status="$task->prioritas->value">{{ $task->prioritas->label() }}</x-badge-status>
    <x-badge-status :status="$task->status->value">{{ $task->status->label() }}</x-badge-status>
    @if(auth()->user()->can('task.edit') && $task->canBeUpdatedBy(auth()->user()))
    <a href="{{ route('task.edit', $task) }}" class="ml-auto shrink-0 text-sm text-indigo-600 hover:underline">Edit</a>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Info task --}}
    <div class="space-y-4">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="font-medium text-gray-700 text-sm mb-3">Detail Task</h3>
            <dl class="space-y-2 text-sm">
                <div><dt class="text-gray-400">Program</dt><dd class="text-gray-800">{{ $task->kegiatan->programKerja->nama_program }}</dd></div>
                <div><dt class="text-gray-400">Kegiatan</dt><dd><a href="{{ route('kegiatan.show', $task->kegiatan) }}" class="text-indigo-600 hover:underline">{{ $task->kegiatan->nama_kegiatan }}</a></dd></div>
                <div><dt class="text-gray-400">Pelaksana</dt><dd class="text-gray-800">{{ $task->assignee->nama_pegawai }}</dd></div>
                <div><dt class="text-gray-400">Due Date</dt>
                    <dd class="{{ $task->due_date && $task->due_date->isPast() && $task->status->value !== 'done' ? 'text-red-600 font-medium' : 'text-gray-800' }}">
                        {{ $task->due_date?->format('d M Y') ?? '-' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-gray-400 mb-1">Progress</dt>
                    <dd>
                        <div class="flex items-center gap-2">
                            <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-indigo-500 rounded-full" style="width: {{ $task->progress_persen }}%"></div>
                            </div>
                            <span class="text-sm font-semibold text-gray-700">{{ $task->progress_persen }}%</span>
                        </div>
                    </dd>
                </div>
            </dl>
        </div>

        @if($task->deskripsi_task)
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="font-medium text-gray-700 text-sm mb-2">Deskripsi</h3>
            <p class="text-sm text-gray-600">{{ $task->deskripsi_task }}</p>
        </div>
        @endif
    </div>

    {{-- Tab area --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- Daily Scrum --}}
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-medium text-gray-700">Daily Scrum ({{ $task->dailyScrums->count() }})</h3>
                @can('daily-scrum.create')
                <a href="{{ route('daily-scrum.create') }}?task_id={{ $task->id }}" class="text-xs bg-indigo-600 text-white px-3 py-1 rounded-lg hover:bg-indigo-700">+ Tambah</a>
                @endcan
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($task->dailyScrums->take(5) as $scrum)
                <div class="px-5 py-3">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs font-medium text-gray-500">{{ $scrum->tanggal->format('d M Y') }}</span>
                        <span class="text-xs text-gray-400">{{ $scrum->pegawai->nama_pegawai }}</span>
                    </div>
                    <p class="text-sm text-gray-700">{{ $scrum->rencana_kerja_harian }}</p>
                    @if($scrum->realisasi)
                    <p class="text-xs text-gray-400 mt-1">Realisasi: {{ $scrum->realisasi }}</p>
                    @endif
                </div>
                @empty
                <div class="px-5 py-6 text-center text-sm text-gray-400">Belum ada daily scrum</div>
                @endforelse
            </div>
        </div>

        {{-- Bukti Aktivitas --}}
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-medium text-gray-700">Bukti Aktivitas ({{ $task->buktiAktivitas->count() }})</h3>
                @can('bukti-aktivitas.create')
                <a href="{{ route('bukti-aktivitas.create') }}?task_id={{ $task->id }}" class="text-xs bg-indigo-600 text-white px-3 py-1 rounded-lg hover:bg-indigo-700">+ Tambah</a>
                @endcan
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($task->buktiAktivitas as $bukti)
                <div class="px-5 py-3 flex items-center gap-3">
                    <x-badge-status :status="'planning'">{{ $bukti->jenis_bukti->label() }}</x-badge-status>
                    @if($bukti->jenis_bukti->value === 'link')
                    <a href="{{ $bukti->sumber_bukti }}" target="_blank" class="text-sm text-indigo-600 hover:underline truncate">{{ $bukti->sumber_bukti }}</a>
                    @else
                    <span class="text-sm text-gray-700 truncate">{{ $bukti->sumber_bukti }}</span>
                    @endif
                </div>
                @empty
                <div class="px-5 py-6 text-center text-sm text-gray-400">Belum ada bukti aktivitas</div>
                @endforelse
            </div>
        </div>

        {{-- GitHub --}}
        @if($task->githubActivities->isNotEmpty())
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="font-medium text-gray-700">GitHub Activity ({{ $task->githubActivities->count() }})</h3>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach($task->githubActivities as $gh)
                <div class="px-5 py-3 text-sm">
                    <p class="font-medium text-gray-800">{{ $gh->repo_name }} @if($gh->branch_name)<span class="text-gray-400 font-normal">/ {{ $gh->branch_name }}</span>@endif</p>
                    @if($gh->commit_message)<p class="text-gray-500 mt-0.5 truncate">{{ $gh->commit_message }}</p>@endif
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
