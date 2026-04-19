@extends('layouts.app')
@section('title', 'Laporan Bulanan')
@section('content')

<x-page-header title="Laporan Bulanan" />

<div class="bg-white rounded-xl border border-gray-200 p-5 mb-6">
    <form method="GET" action="{{ route('laporan.index') }}" class="flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Mode Laporan</label>
            <select name="mode" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="detail" @selected($reportMode === 'detail')>Detail Teknis</option>
                <option value="umum" @selected($reportMode === 'umum')>Umum Non-Teknis</option>
            </select>
        </div>

        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Bulan</label>
            <select name="bulan" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @foreach(range(1, 12) as $m)
                <option value="{{ $m }}" @selected($bulan === $m)>{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Tahun</label>
            <select name="tahun" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @foreach(range(now()->year - 2, now()->year + 1) as $y)
                <option value="{{ $y }}" @selected($tahun === $y)>{{ $y }}</option>
                @endforeach
            </select>
        </div>

        @if($canViewAllTasks)
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Pegawai</label>
            <select name="pegawai_id" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Semua Pegawai</option>
                @foreach($pegawaiList as $pegawai)
                <option value="{{ $pegawai->id }}" @selected($pegawaiId === $pegawai->id)>{{ $pegawai->nama_pegawai }}</option>
                @endforeach
            </select>
        </div>
        @else
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Pegawai</label>
            <div class="border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 bg-gray-50 min-w-56">
                {{ $selectedPegawai?->nama_pegawai ?? 'Belum terhubung ke data pegawai' }}
            </div>
        </div>
        @endif

        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Program Kerja</label>
            <select name="program_kerja_id" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Semua Program</option>
                @foreach($programs as $program)
                <option value="{{ $program->id }}" @selected($programId === $program->id)>{{ $program->nama_program }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg">Tampilkan</button>
        <a href="{{ route('laporan.index') }}" class="border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium px-4 py-2 rounded-lg">Reset</a>
        <a href="{{ route('laporan.export', $queryParams) }}" class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-4 py-2 rounded-lg">Export PDF</a>
    </form>
</div>

@if($reportMode === 'umum')
    @include('laporan.partials.preview-umum')
@else
    @include('laporan.partials.preview-detail')
@endif
@endsection
