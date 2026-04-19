@extends('layouts.app')
@section('title', 'Edit Pegawai')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('pegawai.index') }}" class="btn btn-sm btn-ghost-secondary me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M15 6l-6 6l6 6"/></svg>
                </a>
                <h3 class="card-title">Edit Pegawai</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('pegawai.update', $pegawai) }}">
                    @csrf @method('PUT')

                    <x-form-field label="Akun User" name="user_id">
                        <select name="user_id" class="form-select">
                            <option value="">-- Tanpa akun --</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" @selected(old('user_id', $pegawai->user_id) == $user->id)>{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </x-form-field>

                    <x-form-field label="Nama Pegawai" name="nama_pegawai" :required="true">
                        <input type="text" name="nama_pegawai" value="{{ old('nama_pegawai', $pegawai->nama_pegawai) }}"
                            class="form-control @error('nama_pegawai') is-invalid @enderror">
                    </x-form-field>

                    <x-form-field label="NIP" name="nip">
                        <input type="text" name="nip" value="{{ old('nip', $pegawai->nip) }}" class="form-control">
                    </x-form-field>

                    <div class="row">
                        <div class="col-md-6">
                            <x-form-field label="Jabatan" name="jabatan" :required="true">
                                <input type="text" name="jabatan" value="{{ old('jabatan', $pegawai->jabatan) }}"
                                    class="form-control @error('jabatan') is-invalid @enderror">
                            </x-form-field>
                        </div>
                        <div class="col-md-6">
                            <x-form-field label="Unit Kerja" name="unit_kerja" :required="true">
                                <input type="text" name="unit_kerja" value="{{ old('unit_kerja', $pegawai->unit_kerja) }}"
                                    class="form-control @error('unit_kerja') is-invalid @enderror">
                            </x-form-field>
                        </div>
                    </div>

                    <x-form-field label="Status" name="status_pegawai" :required="true">
                        <select name="status_pegawai" class="form-select">
                            <option value="aktif" @selected(old('status_pegawai', $pegawai->status_pegawai->value) === 'aktif')>Aktif</option>
                            <option value="nonaktif" @selected(old('status_pegawai', $pegawai->status_pegawai->value) === 'nonaktif')>Non-Aktif</option>
                        </select>
                    </x-form-field>

                    <div class="row">
                        <div class="col-md-6">
                            <x-form-field label="GitHub Username" name="github_username">
                                <input type="text" name="github_username" value="{{ old('github_username', $pegawai->github_username) }}" class="form-control">
                            </x-form-field>
                        </div>
                        <div class="col-md-6">
                            <x-form-field label="WakaTime User Key" name="wakatime_user_key">
                                <input type="text" name="wakatime_user_key" value="{{ old('wakatime_user_key', $pegawai->wakatime_user_key) }}" class="form-control">
                            </x-form-field>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('pegawai.index') }}" class="btn btn-ghost-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
