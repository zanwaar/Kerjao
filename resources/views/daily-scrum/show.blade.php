@extends('layouts.app')
@section('title', 'Detail Daily Scrum')
@section('content')

<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('daily-scrum.index') }}" class="text-gray-400 hover:text-gray-600">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <h2 class="text-lg font-semibold text-gray-800">Daily Scrum — {{ $dailyScrum->tanggal->format('d M Y') }}</h2>
    <a href="{{ route('daily-scrum.edit', $dailyScrum) }}" class="ml-auto text-sm text-indigo-600 hover:underline">Edit</a>
</div>

<div class="max-w-2xl bg-white rounded-xl border border-gray-200 p-6 space-y-5">
    <div class="flex items-center gap-4 pb-4 border-b border-gray-100">
        <div>
            <p class="font-medium text-gray-800">{{ $dailyScrum->pegawai->nama_pegawai }}</p>
            <p class="text-sm text-gray-400">{{ $dailyScrum->pegawai->jabatan }}</p>
        </div>
    </div>
    <dl class="space-y-4">
        <div>
            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Task</dt>
            <dd><a href="{{ route('task.show', $dailyScrum->task) }}" class="text-sm text-indigo-600 hover:underline">{{ $dailyScrum->task->nama_task }}</a></dd>
        </div>
        <div>
            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Rencana Kerja Harian</dt>
            <dd class="text-sm text-gray-700 whitespace-pre-line">{{ $dailyScrum->rencana_kerja_harian }}</dd>
        </div>
        @if($dailyScrum->indikator_capaian)
        <div>
            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Indikator Capaian</dt>
            <dd class="text-sm text-gray-700">{{ $dailyScrum->indikator_capaian }}</dd>
        </div>
        @endif
        @if($dailyScrum->potensi_risiko)
        <div>
            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Potensi Risiko</dt>
            <dd class="text-sm text-gray-700">{{ $dailyScrum->potensi_risiko }}</dd>
        </div>
        @endif
        @if($dailyScrum->realisasi)
        <div>
            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Realisasi</dt>
            <dd class="text-sm text-gray-700 whitespace-pre-line">{{ $dailyScrum->realisasi }}</dd>
        </div>
        @endif
        @if($dailyScrum->rencana_tindak_lanjut)
        <div>
            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Rencana Tindak Lanjut</dt>
            <dd class="text-sm text-gray-700">{{ $dailyScrum->rencana_tindak_lanjut }}</dd>
        </div>
        @endif
    </dl>
</div>
@endsection
