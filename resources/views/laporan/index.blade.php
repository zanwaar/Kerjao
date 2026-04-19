@extends('layouts.app')
@section('title', 'Laporan Bulanan')
@section('content')

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('laporan.index') }}" class="row g-3 align-items-end">
            <div class="col-auto">
                <label class="form-label">Mode Laporan</label>
                <select name="mode" class="form-select form-select-sm">
                    <option value="detail" @selected($reportMode === 'detail')>Detail Teknis</option>
                    <option value="umum" @selected($reportMode === 'umum')>Umum Non-Teknis</option>
                </select>
            </div>

            <div class="col-auto">
                <label class="form-label">Bulan</label>
                <select name="bulan" class="form-select form-select-sm">
                    @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}" @selected($bulan === $m)>{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-auto">
                <label class="form-label">Tahun</label>
                <select name="tahun" class="form-select form-select-sm">
                    @foreach(range(now()->year - 2, now()->year + 1) as $y)
                    <option value="{{ $y }}" @selected($tahun === $y)>{{ $y }}</option>
                    @endforeach
                </select>
            </div>

            @if($canViewAllTasks)
            <div class="col-auto">
                <label class="form-label">Pegawai</label>
                <select name="pegawai_id" class="form-select form-select-sm">
                    <option value="">Semua Pegawai</option>
                    @foreach($pegawaiList as $pegawai)
                    <option value="{{ $pegawai->id }}" @selected($pegawaiId === $pegawai->id)>{{ $pegawai->nama_pegawai }}</option>
                    @endforeach
                </select>
            </div>
            @else
            <div class="col-auto">
                <label class="form-label">Pegawai</label>
                <div class="form-control form-control-sm bg-light">{{ $selectedPegawai?->nama_pegawai ?? 'Belum terhubung ke data pegawai' }}</div>
            </div>
            @endif

            <div class="col-auto">
                <label class="form-label">Program Kerja</label>
                <select name="program_kerja_id" class="form-select form-select-sm">
                    <option value="">Semua Program</option>
                    @foreach($programs as $program)
                    <option value="{{ $program->id }}" @selected($programId === $program->id)>{{ $program->nama_program }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-auto d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary">Tampilkan</button>
                <a href="{{ route('laporan.index') }}" class="btn btn-sm btn-ghost-secondary">Reset</a>
                <a href="{{ route('laporan.export', $queryParams) }}" class="btn btn-sm btn-success">Export PDF</a>
            </div>
        </form>
    </div>
</div>

@if($reportMode === 'umum')
    @include('laporan.partials.preview-umum')
@else
    @include('laporan.partials.preview-detail')
@endif
@endsection
