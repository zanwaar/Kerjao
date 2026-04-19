@extends('layouts.app')
@section('title', $programKerja->nama_program)
@section('content')

<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('program-kerja.index') }}" class="text-gray-400 hover:text-gray-600">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <h2 class="text-lg font-semibold text-gray-800">{{ $programKerja->nama_program }}</h2>
    <x-badge-status :status="$programKerja->status_program->value">{{ $programKerja->status_program->label() }}</x-badge-status>
    @can('program-kerja.edit')
    <a href="{{ route('program-kerja.edit', $programKerja) }}" class="ml-auto text-sm text-indigo-600 hover:underline">Edit</a>
    @endcan
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
            @can('kegiatan.create')
            <a href="{{ route('kegiatan.create', ['program_kerja_id' => $programKerja->id]) }}" class="text-xs bg-indigo-600 text-white px-3 py-1 rounded-lg hover:bg-indigo-700">+ Tambah</a>
            @endcan
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($programKerja->kegiatan as $kegiatan)
            <div class="px-5 py-3 flex items-center justify-between gap-3">
                <div>
                    <a href="{{ route('kegiatan.show', $kegiatan) }}" class="text-sm font-medium text-gray-800 hover:text-indigo-600">{{ $kegiatan->nama_kegiatan }}</a>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $kegiatan->waktu_mulai->format('d M') }} — {{ $kegiatan->waktu_selesai->format('d M Y') }} · {{ $kegiatan->tasks_count }} task</p>
                </div>
                <x-badge-status :status="$kegiatan->status_kegiatan->value">{{ $kegiatan->status_kegiatan->label() }}</x-badge-status>
            </div>
            @empty
            <div class="px-5 py-8 text-center text-sm text-gray-400">Belum ada kegiatan</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
