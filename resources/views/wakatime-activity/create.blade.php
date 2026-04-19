@extends('layouts.app')
@section('title', 'Tambah WakaTime Activity')
@section('content')
<x-page-header title="Tambah WakaTime Activity" />

<div class="max-w-2xl bg-white rounded-xl border border-gray-200 p-6">
    <form method="POST" action="{{ route('wakatime-activity.store') }}" class="space-y-4">
        @csrf
        <x-form-field label="Task" name="task_id" :required="true">
            <select name="task_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">-- Pilih Task --</option>
                @foreach($tasks as $task)
                <option value="{{ $task->id }}" @selected(old('task_id', $selectedTask) == $task->id)>{{ $task->kegiatan->nama_kegiatan }} · {{ $task->nama_task }}</option>
                @endforeach
            </select>
        </x-form-field>
        <x-form-field label="Pegawai" name="pegawai_id" :required="true">
            <select name="pegawai_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @foreach($pegawaiList as $p)
                <option value="{{ $p->id }}" @selected(old('pegawai_id', $pegawaiUser?->id) == $p->id)>{{ $p->nama_pegawai }}</option>
                @endforeach
            </select>
        </x-form-field>
        <div class="grid grid-cols-2 gap-4">
            <x-form-field label="Tanggal" name="activity_date" :required="true">
                <input type="date" name="activity_date" value="{{ old('activity_date', today()->format('Y-m-d')) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </x-form-field>
            <x-form-field label="Durasi (jam)" name="duration_hours" :required="true">
                <input type="number" name="duration_hours" value="{{ old('duration_hours', 1) }}" min="0" max="24" step="0.25"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </x-form-field>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <x-form-field label="Project Name" name="project_name" :required="true">
                <input type="text" name="project_name" value="{{ old('project_name') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('project_name') border-red-400 @enderror">
            </x-form-field>
            <x-form-field label="Language" name="language_name">
                <input type="text" name="language_name" value="{{ old('language_name') }}" placeholder="PHP, JS, dll"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </x-form-field>
        </div>
        <x-form-field label="Deskripsi" name="description">
            <textarea name="description" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description') }}</textarea>
        </x-form-field>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg">Simpan</button>
            <a href="{{ route('wakatime-activity.index') }}" class="text-sm text-gray-600 px-5 py-2 rounded-lg border border-gray-300">Batal</a>
        </div>
    </form>
</div>
@endsection
