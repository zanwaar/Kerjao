@extends('layouts.app')
@section('title', 'Tambah Program Kerja')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('program-kerja.index') }}" class="btn btn-sm btn-ghost-secondary me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M15 6l-6 6l6 6"/></svg>
                </a>
                <h3 class="card-title">Tambah Program Kerja</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('program-kerja.store') }}">
                    @csrf

                    <x-form-field label="Nama Program" name="nama_program" :required="true">
                        <input type="text" name="nama_program" id="nama_program" value="{{ old('nama_program') }}"
                            class="form-control @error('nama_program') is-invalid @enderror">
                    </x-form-field>

                    <x-form-field label="Deskripsi" name="deskripsi">
                        <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control">{{ old('deskripsi') }}</textarea>
                    </x-form-field>

                    <div class="row">
                        <div class="col-md-6">
                            <x-form-field label="Waktu Mulai" name="waktu_mulai" :required="true">
                                <input type="date" name="waktu_mulai" id="waktu_mulai" value="{{ old('waktu_mulai') }}"
                                    class="form-control">
                            </x-form-field>
                        </div>
                        <div class="col-md-6">
                            <x-form-field label="Waktu Selesai" name="waktu_selesai" :required="true">
                                <input type="date" name="waktu_selesai" id="waktu_selesai" value="{{ old('waktu_selesai') }}"
                                    class="form-control">
                            </x-form-field>
                        </div>
                    </div>

                    <x-form-field label="Status" name="status_program" :required="true">
                        <select name="status_program" id="status_program" class="form-select">
                            @foreach($statuses as $s)
                            <option value="{{ $s->value }}" @selected(old('status_program', 'planning') === $s->value)>{{ $s->label() }}</option>
                            @endforeach
                        </select>
                    </x-form-field>

                    <div class="card-footer d-flex gap-2 px-0 pb-0 mt-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('program-kerja.index') }}" class="btn btn-ghost-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
