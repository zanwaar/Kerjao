@extends('layouts.app')
@section('title', 'Edit Program Kerja')
@section('content')
<x-page-header title="Edit Program Kerja" />

<div class="max-w-2xl bg-white rounded-xl border border-gray-200 p-6">
    <form method="POST" action="{{ route('program-kerja.update', $programKerja) }}" class="space-y-4">
        @csrf @method('PUT')
        <x-form-field label="Nama Program" name="nama_program" :required="true">
            <input type="text" name="nama_program" id="nama_program" value="{{ old('nama_program', $programKerja->nama_program) }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </x-form-field>
        <x-form-field label="Deskripsi" name="deskripsi">
            <textarea name="deskripsi" id="deskripsi" rows="3"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('deskripsi', $programKerja->deskripsi) }}</textarea>
        </x-form-field>
        <div class="grid grid-cols-2 gap-4">
            <x-form-field label="Waktu Mulai" name="waktu_mulai" :required="true">
                <input type="date" name="waktu_mulai" id="waktu_mulai" value="{{ old('waktu_mulai', $programKerja->waktu_mulai->format('Y-m-d')) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </x-form-field>
            <x-form-field label="Waktu Selesai" name="waktu_selesai" :required="true">
                <input type="date" name="waktu_selesai" id="waktu_selesai" value="{{ old('waktu_selesai', $programKerja->waktu_selesai->format('Y-m-d')) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </x-form-field>
        </div>
        <x-form-field label="Status" name="status_program" :required="true">
            <select name="status_program" id="status_program" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @foreach($statuses as $s)
                <option value="{{ $s->value }}" @selected(old('status_program', $programKerja->status_program->value) === $s->value)>{{ $s->label() }}</option>
                @endforeach
            </select>
        </x-form-field>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg">Simpan</button>
            <a href="{{ route('program-kerja.index') }}" class="text-sm text-gray-600 px-5 py-2 rounded-lg border border-gray-300">Batal</a>
        </div>
    </form>
</div>
@endsection
