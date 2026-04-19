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
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-medium text-gray-700">Task Aktif</h3>
                <span class="text-xs text-gray-400">{{ $pegawai->tasks->count() }} task</span>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($pegawai->tasks as $task)
                <div class="px-5 py-3 flex items-center justify-between gap-3">
                    <div>
                        <a href="{{ route('task.show', $task) }}" class="text-sm font-medium text-gray-800 hover:text-indigo-600">{{ $task->nama_task }}</a>
                        <p class="text-xs text-gray-400">{{ $task->kegiatan->programKerja->nama_program }} · {{ $task->kegiatan->nama_kegiatan }}</p>
                    </div>
                    <x-badge-status :status="$task->status->value">{{ $task->status->label() }}</x-badge-status>
                </div>
                @empty
                <div class="px-5 py-6 text-center text-sm text-gray-400">Tidak ada task</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
