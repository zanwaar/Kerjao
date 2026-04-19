@extends('layouts.app')
@section('title', $kegiatan->nama_kegiatan)
@section('content')

<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('kegiatan.index') }}" class="text-gray-400 hover:text-gray-600">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <h2 class="text-lg font-semibold text-gray-800">{{ $kegiatan->nama_kegiatan }}</h2>
    <x-badge-status :status="$kegiatan->status_kegiatan->value">{{ $kegiatan->status_kegiatan->label() }}</x-badge-status>
    @if(auth()->user()->can('kegiatan.edit') && $kegiatan->canBeManagedBy(auth()->user()))
    <a href="{{ route('kegiatan.edit', $kegiatan) }}" class="ml-auto text-sm text-indigo-600 hover:underline">Edit</a>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl border border-gray-200 p-5 space-y-3">
        <h3 class="font-medium text-gray-700 text-sm">Informasi Kegiatan</h3>
        <dl class="space-y-2 text-sm">
            <div><dt class="text-gray-400">Program</dt><dd><a href="{{ route('program-kerja.show', $kegiatan->programKerja) }}" class="text-indigo-600 hover:underline">{{ $kegiatan->programKerja->nama_program }}</a></dd></div>
            <div><dt class="text-gray-400">Mulai</dt><dd class="text-gray-800">{{ $kegiatan->waktu_mulai->format('d M Y') }}</dd></div>
            <div><dt class="text-gray-400">Selesai</dt><dd class="text-gray-800">{{ $kegiatan->waktu_selesai->format('d M Y') }}</dd></div>
            @if($kegiatan->target_capaian)
            <div><dt class="text-gray-400">Target</dt><dd class="text-gray-700">{{ $kegiatan->target_capaian }}</dd></div>
            @endif
        </dl>
    </div>

    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-medium text-gray-700">Task ({{ $kegiatan->tasks->count() }})</h3>
            @if(auth()->user()->can('task.create') && $kegiatan->canBeManagedBy(auth()->user()))
            <a href="{{ route('task.create', ['kegiatan_id' => $kegiatan->id]) }}" class="text-xs bg-indigo-600 text-white px-3 py-1 rounded-lg hover:bg-indigo-700">+ Tambah Task</a>
            @endif
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($kegiatan->tasks as $task)
            <div class="px-5 py-3 flex items-center justify-between gap-3">
                <div>
                    <a href="{{ route('task.show', $task) }}" class="text-sm font-medium text-gray-800 hover:text-indigo-600">{{ $task->nama_task }}</a>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $task->assignee->nama_pegawai }} · Due {{ $task->due_date?->format('d M Y') ?? '-' }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-gray-500">{{ $task->progress_persen }}%</span>
                    <x-badge-status :status="$task->status->value">{{ $task->status->label() }}</x-badge-status>
                </div>
            </div>
            @empty
            <div class="px-5 py-8 text-center text-sm text-gray-400">Belum ada task</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
