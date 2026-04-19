@extends('layouts.app')
@section('title', 'Tambah Task')
@section('content')
<x-page-header title="Tambah Task" />

<div class="max-w-2xl bg-white rounded-xl border border-gray-200 p-6">
    <form method="POST" action="{{ route('task.store') }}" class="space-y-4">
        @csrf
        <x-form-field label="Kegiatan" name="kegiatan_id" :required="true">
            <select name="kegiatan_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('kegiatan_id') border-red-400 @enderror">
                <option value="">-- Pilih Kegiatan --</option>
                @foreach($kegiatan as $k)
                <option value="{{ $k->id }}" @selected(old('kegiatan_id', $selectedKegiatan) == $k->id)>{{ $k->programKerja->nama_program }} · {{ $k->nama_kegiatan }}</option>
                @endforeach
            </select>
        </x-form-field>
        <x-form-field label="Pelaksana" name="assigned_to" :required="true">
            <select name="assigned_to" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('assigned_to') border-red-400 @enderror">
                <option value="">-- Pilih Pegawai --</option>
                @foreach($pegawai as $p)
                <option value="{{ $p->id }}" @selected(old('assigned_to') == $p->id)>{{ $p->nama_pegawai }} — {{ $p->jabatan }}</option>
                @endforeach
            </select>
        </x-form-field>
        <x-form-field label="Nama Task" name="nama_task" :required="true">
            <input type="text" name="nama_task" value="{{ old('nama_task') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('nama_task') border-red-400 @enderror">
        </x-form-field>
        <x-form-field label="Deskripsi" name="deskripsi_task">
            <textarea id="deskripsi_task" name="deskripsi_task" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('deskripsi_task') }}</textarea>
            <x-ai-writing-assist context="task_description" target="deskripsi_task" />
        </x-form-field>
        <div class="grid grid-cols-3 gap-4">
            <x-form-field label="Status" name="status" :required="true">
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @foreach($statuses as $s)
                    <option value="{{ $s->value }}" @selected(old('status', 'not_started') === $s->value)>{{ $s->label() }}</option>
                    @endforeach
                </select>
            </x-form-field>
            <x-form-field label="Prioritas" name="prioritas" :required="true">
                <select name="prioritas" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @foreach($priorities as $p)
                    <option value="{{ $p->value }}" @selected(old('prioritas', 'medium') === $p->value)>{{ $p->label() }}</option>
                    @endforeach
                </select>
            </x-form-field>
            <x-form-field label="Progress (%)" name="progress_persen" :required="true">
                <input type="number" name="progress_persen" value="{{ old('progress_persen', 0) }}" min="0" max="100"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </x-form-field>
        </div>
        <x-form-field label="Due Date" name="due_date">
            <input type="date" name="due_date" value="{{ old('due_date') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </x-form-field>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg">Simpan</button>
            <a href="{{ route('task.index') }}" class="text-sm text-gray-600 px-5 py-2 rounded-lg border border-gray-300">Batal</a>
        </div>
    </form>
</div>
@endsection
