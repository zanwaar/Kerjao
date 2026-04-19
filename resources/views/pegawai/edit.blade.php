@extends('layouts.app')
@section('title', 'Edit Pegawai')
@section('content')

<x-page-header title="Edit Pegawai" />

<div class="max-w-2xl bg-white rounded-xl border border-gray-200 p-6">
    <form method="POST" action="{{ route('pegawai.update', $pegawai) }}" class="space-y-4">
        @csrf @method('PUT')

        <x-form-field label="Akun User" name="user_id">
            <select name="user_id" id="user_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">-- Tanpa akun --</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}" @selected(old('user_id', $pegawai->user_id) == $user->id)>{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </x-form-field>

        <x-form-field label="Nama Pegawai" name="nama_pegawai" :required="true">
            <input type="text" name="nama_pegawai" id="nama_pegawai" value="{{ old('nama_pegawai', $pegawai->nama_pegawai) }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('nama_pegawai') border-red-400 @enderror">
        </x-form-field>

        <x-form-field label="NIP" name="nip">
            <input type="text" name="nip" id="nip" value="{{ old('nip', $pegawai->nip) }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </x-form-field>

        <div class="grid grid-cols-2 gap-4">
            <x-form-field label="Jabatan" name="jabatan" :required="true">
                <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan', $pegawai->jabatan) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </x-form-field>
            <x-form-field label="Unit Kerja" name="unit_kerja" :required="true">
                <input type="text" name="unit_kerja" id="unit_kerja" value="{{ old('unit_kerja', $pegawai->unit_kerja) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </x-form-field>
        </div>

        <x-form-field label="Status" name="status_pegawai" :required="true">
            <select name="status_pegawai" id="status_pegawai" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="aktif" @selected(old('status_pegawai', $pegawai->status_pegawai->value) === 'aktif')>Aktif</option>
                <option value="nonaktif" @selected(old('status_pegawai', $pegawai->status_pegawai->value) === 'nonaktif')>Non-Aktif</option>
            </select>
        </x-form-field>

        <div class="grid grid-cols-2 gap-4">
            <x-form-field label="GitHub Username" name="github_username">
                <input type="text" name="github_username" id="github_username" value="{{ old('github_username', $pegawai->github_username) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </x-form-field>
            <x-form-field label="WakaTime User Key" name="wakatime_user_key">
                <input type="text" name="wakatime_user_key" id="wakatime_user_key" value="{{ old('wakatime_user_key', $pegawai->wakatime_user_key) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </x-form-field>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition-colors">Simpan</button>
            <a href="{{ route('pegawai.index') }}" class="text-sm text-gray-600 hover:text-gray-800 px-5 py-2 rounded-lg border border-gray-300">Batal</a>
        </div>
    </form>
</div>
@endsection
