@extends('layouts.app')
@section('title', 'Edit Daily Scrum')
@section('content')
<x-page-header title="Edit Daily Scrum" />

<div class="max-w-2xl bg-white rounded-xl border border-gray-200 p-6">
    <form method="POST" action="{{ route('daily-scrum.update', $dailyScrum) }}" class="space-y-4">
        @csrf @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <x-form-field label="Pegawai" name="pegawai_id" :required="true">
                <select name="pegawai_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @foreach($pegawaiList as $p)
                    <option value="{{ $p->id }}" @selected(old('pegawai_id', $dailyScrum->pegawai_id) == $p->id)>{{ $p->nama_pegawai }}</option>
                    @endforeach
                </select>
            </x-form-field>
            <x-form-field label="Tanggal" name="tanggal" :required="true">
                <input type="date" name="tanggal" value="{{ old('tanggal', $dailyScrum->tanggal->format('Y-m-d')) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </x-form-field>
        </div>
        <x-form-field label="Task" name="task_id" :required="true">
            <select name="task_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @foreach($tasks as $task)
                <option value="{{ $task->id }}" @selected(old('task_id', $dailyScrum->task_id) == $task->id)>{{ $task->kegiatan->nama_kegiatan }} · {{ $task->nama_task }}</option>
                @endforeach
            </select>
        </x-form-field>
        <x-form-field label="Rencana Kerja Harian" name="rencana_kerja_harian" :required="true">
            <textarea id="rencana_kerja_harian" name="rencana_kerja_harian" rows="3"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('rencana_kerja_harian', $dailyScrum->rencana_kerja_harian) }}</textarea>
            <x-ai-writing-assist context="daily_plan" target="rencana_kerja_harian" />
        </x-form-field>
        <x-form-field label="Indikator Capaian" name="indikator_capaian">
            <textarea id="indikator_capaian" name="indikator_capaian" rows="2"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('indikator_capaian', $dailyScrum->indikator_capaian) }}</textarea>
            <x-ai-writing-assist context="daily_indicator" target="indikator_capaian" />
        </x-form-field>
        <x-form-field label="Potensi Risiko" name="potensi_risiko">
            <textarea id="potensi_risiko" name="potensi_risiko" rows="2"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('potensi_risiko', $dailyScrum->potensi_risiko) }}</textarea>
            <x-ai-writing-assist context="daily_risk" target="potensi_risiko" />
        </x-form-field>
        <x-form-field label="Realisasi" name="realisasi">
            <textarea id="realisasi" name="realisasi" rows="2"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('realisasi', $dailyScrum->realisasi) }}</textarea>
            <x-ai-writing-assist context="daily_realization" target="realisasi" />
        </x-form-field>
        <x-form-field label="Rencana Tindak Lanjut" name="rencana_tindak_lanjut">
            <textarea id="rencana_tindak_lanjut" name="rencana_tindak_lanjut" rows="2"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('rencana_tindak_lanjut', $dailyScrum->rencana_tindak_lanjut) }}</textarea>
            <x-ai-writing-assist context="daily_follow_up" target="rencana_tindak_lanjut" />
        </x-form-field>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg">Simpan</button>
            <a href="{{ route('daily-scrum.index') }}" class="text-sm text-gray-600 px-5 py-2 rounded-lg border border-gray-300">Batal</a>
        </div>
    </form>
</div>
@endsection
