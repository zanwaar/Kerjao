@extends('layouts.app')
@section('title', 'Edit Daily Scrum')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('daily-scrum.index') }}" class="btn btn-sm btn-ghost-secondary me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M15 6l-6 6l6 6"/></svg>
                </a>
                <h3 class="card-title">Edit Daily Scrum</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('daily-scrum.update', $dailyScrum) }}">
                    @csrf @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <x-form-field label="Pegawai" name="pegawai_id" :required="true">
                                <select name="pegawai_id" class="form-select">
                                    @foreach($pegawaiList as $p)
                                    <option value="{{ $p->id }}" @selected(old('pegawai_id', $dailyScrum->pegawai_id) == $p->id)>{{ $p->nama_pegawai }}</option>
                                    @endforeach
                                </select>
                            </x-form-field>
                        </div>
                        <div class="col-md-6">
                            <x-form-field label="Tanggal" name="tanggal" :required="true">
                                <input type="date" name="tanggal" value="{{ old('tanggal', $dailyScrum->tanggal->format('Y-m-d')) }}" class="form-control">
                            </x-form-field>
                        </div>
                    </div>

                    <x-form-field label="Task" name="task_id" :required="true">
                        <select name="task_id" class="form-select">
                            @foreach($tasks as $task)
                            <option value="{{ $task->id }}" @selected(old('task_id', $dailyScrum->task_id) == $task->id)>{{ $task->kegiatan->nama_kegiatan }} · {{ $task->nama_task }}</option>
                            @endforeach
                        </select>
                    </x-form-field>

                    <x-form-field label="Rencana Kerja Harian" name="rencana_kerja_harian" :required="true">
                        <textarea id="rencana_kerja_harian" name="rencana_kerja_harian" rows="3" class="form-control">{{ old('rencana_kerja_harian', $dailyScrum->rencana_kerja_harian) }}</textarea>
                        <x-ai-writing-assist context="daily_plan" target="rencana_kerja_harian" />
                    </x-form-field>

                    <x-form-field label="Indikator Capaian" name="indikator_capaian">
                        <textarea id="indikator_capaian" name="indikator_capaian" rows="2" class="form-control">{{ old('indikator_capaian', $dailyScrum->indikator_capaian) }}</textarea>
                        <x-ai-writing-assist context="daily_indicator" target="indikator_capaian" />
                    </x-form-field>

                    <x-form-field label="Potensi Risiko" name="potensi_risiko">
                        <textarea id="potensi_risiko" name="potensi_risiko" rows="2" class="form-control">{{ old('potensi_risiko', $dailyScrum->potensi_risiko) }}</textarea>
                        <x-ai-writing-assist context="daily_risk" target="potensi_risiko" />
                    </x-form-field>

                    <x-form-field label="Realisasi" name="realisasi">
                        <textarea id="realisasi" name="realisasi" rows="2" class="form-control">{{ old('realisasi', $dailyScrum->realisasi) }}</textarea>
                        <x-ai-writing-assist context="daily_realization" target="realisasi" />
                    </x-form-field>

                    <x-form-field label="Rencana Tindak Lanjut" name="rencana_tindak_lanjut">
                        <textarea id="rencana_tindak_lanjut" name="rencana_tindak_lanjut" rows="2" class="form-control">{{ old('rencana_tindak_lanjut', $dailyScrum->rencana_tindak_lanjut) }}</textarea>
                        <x-ai-writing-assist context="daily_follow_up" target="rencana_tindak_lanjut" />
                    </x-form-field>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('daily-scrum.index') }}" class="btn btn-ghost-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
