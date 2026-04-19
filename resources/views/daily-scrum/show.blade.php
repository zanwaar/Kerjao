@extends('layouts.app')
@section('title', 'Detail Daily Scrum')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('daily-scrum.index') }}" class="btn btn-sm btn-ghost-secondary me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M15 6l-6 6l6 6"/></svg>
                </a>
                <h3 class="card-title">Daily Scrum — {{ $dailyScrum->tanggal->format('d M Y') }}</h3>
                <div class="card-options">
                    <a href="{{ route('daily-scrum.edit', $dailyScrum) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 pb-3 mb-3 border-bottom">
                    <div class="avatar bg-primary-lt">{{ strtoupper(substr($dailyScrum->pegawai->nama_pegawai, 0, 1)) }}</div>
                    <div>
                        <div class="fw-medium">{{ $dailyScrum->pegawai->nama_pegawai }}</div>
                        <div class="text-secondary small">{{ $dailyScrum->pegawai->jabatan }}</div>
                    </div>
                </div>

                <dl>
                    <dt class="text-secondary small fw-semibold text-uppercase mb-1">Task</dt>
                    <dd class="mb-3">
                        <a href="{{ route('task.show', $dailyScrum->task) }}" class="text-primary">{{ $dailyScrum->task->nama_task }}</a>
                    </dd>

                    <dt class="text-secondary small fw-semibold text-uppercase mb-1">Rencana Kerja Harian</dt>
                    <dd class="mb-3 text-body" style="white-space: pre-line">{{ $dailyScrum->rencana_kerja_harian }}</dd>

                    @if($dailyScrum->indikator_capaian)
                    <dt class="text-secondary small fw-semibold text-uppercase mb-1">Indikator Capaian</dt>
                    <dd class="mb-3 text-body">{{ $dailyScrum->indikator_capaian }}</dd>
                    @endif

                    @if($dailyScrum->potensi_risiko)
                    <dt class="text-secondary small fw-semibold text-uppercase mb-1">Potensi Risiko</dt>
                    <dd class="mb-3 text-body">{{ $dailyScrum->potensi_risiko }}</dd>
                    @endif

                    @if($dailyScrum->realisasi)
                    <dt class="text-secondary small fw-semibold text-uppercase mb-1">Realisasi</dt>
                    <dd class="mb-3 text-body" style="white-space: pre-line">{{ $dailyScrum->realisasi }}</dd>
                    @endif

                    @if($dailyScrum->rencana_tindak_lanjut)
                    <dt class="text-secondary small fw-semibold text-uppercase mb-1">Rencana Tindak Lanjut</dt>
                    <dd class="mb-0 text-body">{{ $dailyScrum->rencana_tindak_lanjut }}</dd>
                    @endif
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
