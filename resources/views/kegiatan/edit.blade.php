@extends('layouts.app')
@section('title', 'Edit Kegiatan')
@section('content')
<x-page-header title="Edit Kegiatan" />

<div class="max-w-2xl bg-white rounded-xl border border-gray-200 p-6">
    <form method="POST" action="{{ route('kegiatan.update', $kegiatan) }}" class="space-y-4">
        @csrf @method('PUT')
        <x-form-field label="Program Kerja" name="program_kerja_id" :required="true">
            <select name="program_kerja_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @foreach($programs as $p)
                <option value="{{ $p->id }}" @selected(old('program_kerja_id', $kegiatan->program_kerja_id) == $p->id)>{{ $p->nama_program }}</option>
                @endforeach
            </select>
        </x-form-field>
        <x-form-field label="Nama Kegiatan" name="nama_kegiatan" :required="true">
            <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan', $kegiatan->nama_kegiatan) }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </x-form-field>
        <x-form-field label="Deskripsi" name="deskripsi">
            <textarea name="deskripsi" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
        </x-form-field>
        <x-form-field label="Target Capaian" name="target_capaian">
            <textarea name="target_capaian" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('target_capaian', $kegiatan->target_capaian) }}</textarea>
        </x-form-field>
        <div class="grid grid-cols-2 gap-4">
            <x-form-field label="Waktu Mulai" name="waktu_mulai" :required="true">
                <input type="date" name="waktu_mulai" value="{{ old('waktu_mulai', $kegiatan->waktu_mulai->format('Y-m-d')) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </x-form-field>
            <x-form-field label="Waktu Selesai" name="waktu_selesai" :required="true">
                <input type="date" name="waktu_selesai" value="{{ old('waktu_selesai', $kegiatan->waktu_selesai->format('Y-m-d')) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </x-form-field>
        </div>
        <x-form-field label="Status" name="status_kegiatan" :required="true">
            <select name="status_kegiatan" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @foreach($statuses as $s)
                <option value="{{ $s->value }}" @selected(old('status_kegiatan', $kegiatan->status_kegiatan->value) === $s->value)>{{ $s->label() }}</option>
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
