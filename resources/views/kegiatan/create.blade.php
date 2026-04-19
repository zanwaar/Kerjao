@extends('layouts.app')
@section('title', 'Tambah Kegiatan')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('kegiatan.index') }}" class="btn btn-sm btn-ghost-secondary me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M15 6l-6 6l6 6"/></svg>
                </a>
                <h3 class="card-title">Tambah Kegiatan</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('kegiatan.store') }}">
                    @csrf

                    @if($programs->isEmpty())
                    <div class="alert alert-warning mb-3">
                        Belum ada program kerja yang bisa dipakai. Buat program kerja Anda sendiri terlebih dahulu.
                    </div>
                    @endif

                    <x-form-field label="Program Kerja" name="program_kerja_id" :required="true">
                        <select name="program_kerja_id" id="program_kerja_id" class="form-select @error('program_kerja_id') is-invalid @enderror">
                            <option value="">-- Pilih Program --</option>
                            @foreach($programs as $p)
                            <option value="{{ $p->id }}" @selected(old('program_kerja_id', $selectedProgram) == $p->id)>{{ $p->nama_program }}</option>
                            @endforeach
                        </select>
                    </x-form-field>

                    <x-form-field label="Nama Kegiatan" name="nama_kegiatan" :required="true">
                        <input type="text" name="nama_kegiatan" id="nama_kegiatan" value="{{ old('nama_kegiatan') }}"
                            class="form-control @error('nama_kegiatan') is-invalid @enderror">
                    </x-form-field>

                    <x-form-field label="Deskripsi" name="deskripsi">
                        <textarea name="deskripsi" rows="3" class="form-control">{{ old('deskripsi') }}</textarea>
                    </x-form-field>

                    <x-form-field label="Target Capaian" name="target_capaian">
                        <textarea name="target_capaian" rows="2" class="form-control">{{ old('target_capaian') }}</textarea>
                    </x-form-field>

                    <div class="row">
                        <div class="col-md-6">
                            <x-form-field label="Waktu Mulai" name="waktu_mulai" :required="true">
                                <input type="date" name="waktu_mulai" value="{{ old('waktu_mulai') }}" class="form-control">
                            </x-form-field>
                        </div>
                        <div class="col-md-6">
                            <x-form-field label="Waktu Selesai" name="waktu_selesai" :required="true">
                                <input type="date" name="waktu_selesai" value="{{ old('waktu_selesai') }}" class="form-control">
                            </x-form-field>
                        </div>
                    </div>

                    <x-form-field label="Status" name="status_kegiatan" :required="true">
                        <select name="status_kegiatan" class="form-select">
                            @foreach($statuses as $s)
                            <option value="{{ $s->value }}" @selected(old('status_kegiatan', 'planning') === $s->value)>{{ $s->label() }}</option>
                            @endforeach
                        </select>
                    </x-form-field>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" @disabled($programs->isEmpty()) class="btn btn-primary">Simpan</button>
                        <a href="{{ route('kegiatan.index') }}" class="btn btn-ghost-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
