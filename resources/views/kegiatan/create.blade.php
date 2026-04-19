@extends('layouts.app')
@section('title', 'Tambah Kegiatan')
@section('content')
<x-page-header title="Tambah Kegiatan" />

<div class="max-w-2xl bg-white rounded-xl border border-gray-200 p-6">
    <form method="POST" action="{{ route('kegiatan.store') }}" class="space-y-4">
        @csrf
        <x-form-field label="Program Kerja" name="program_kerja_id" :required="true">
            <select name="program_kerja_id" id="program_kerja_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('program_kerja_id') border-red-400 @enderror">
                <option value="">-- Pilih Program --</option>
                @foreach($programs as $p)
                <option value="{{ $p->id }}" @selected(old('program_kerja_id', $selectedProgram) == $p->id)>{{ $p->nama_program }}</option>
                @endforeach
            </select>
        </x-form-field>
        <x-form-field label="Nama Kegiatan" name="nama_kegiatan" :required="true">
            <input type="text" name="nama_kegiatan" id="nama_kegiatan" value="{{ old('nama_kegiatan') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('nama_kegiatan') border-red-400 @enderror">
        </x-form-field>
        <x-form-field label="Deskripsi" name="deskripsi">
            <textarea name="deskripsi" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('deskripsi') }}</textarea>
        </x-form-field>
        <x-form-field label="Target Capaian" name="target_capaian">
            <textarea name="target_capaian" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('target_capaian') }}</textarea>
        </x-form-field>
        <div class="grid grid-cols-2 gap-4">
            <x-form-field label="Waktu Mulai" name="waktu_mulai" :required="true">
                <input type="date" name="waktu_mulai" value="{{ old('waktu_mulai') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </x-form-field>
            <x-form-field label="Waktu Selesai" name="waktu_selesai" :required="true">
                <input type="date" name="waktu_selesai" value="{{ old('waktu_selesai') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </x-form-field>
        </div>
        <x-form-field label="Status" name="status_kegiatan" :required="true">
            <select name="status_kegiatan" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @foreach($statuses as $s)
                <option value="{{ $s->value }}" @selected(old('status_kegiatan', 'planning') === $s->value)>{{ $s->label() }}</option>
                @endforeach
            </select>
        </x-form-field>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg">Simpan</button>
            <a href="{{ route('kegiatan.index') }}" class="text-sm text-gray-600 px-5 py-2 rounded-lg border border-gray-300">Batal</a>
        </div>
    </form>
</div>
@endsection
