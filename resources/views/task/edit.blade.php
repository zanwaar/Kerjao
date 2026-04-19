@extends('layouts.app')
@section('title', 'Edit Task')
@section('content')
<x-page-header title="Edit Task" />

<div class="max-w-2xl bg-white rounded-xl border border-gray-200 p-6">
    <form method="POST" action="{{ route('task.update', $task) }}" class="space-y-4">
        @csrf @method('PUT')
        @if($canManageTask)
        <x-form-field label="Kegiatan" name="kegiatan_id" :required="true">
            <select name="kegiatan_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @foreach($kegiatan as $k)
                <option value="{{ $k->id }}" @selected(old('kegiatan_id', $task->kegiatan_id) == $k->id)>{{ $k->programKerja->nama_program }} · {{ $k->nama_kegiatan }}</option>
                @endforeach
            </select>
        </x-form-field>
        <x-form-field label="Pelaksana" name="assigned_to" :required="true">
            <select name="assigned_to" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @foreach($pegawai as $p)
                <option value="{{ $p->id }}" @selected(old('assigned_to', $task->assigned_to) == $p->id)>{{ $p->nama_pegawai }} — {{ $p->jabatan }}</option>
                @endforeach
            </select>
        </x-form-field>
        <x-form-field label="Nama Task" name="nama_task" :required="true">
            <input type="text" name="nama_task" value="{{ old('nama_task', $task->nama_task) }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </x-form-field>
        <x-form-field label="Deskripsi" name="deskripsi_task">
            <textarea id="deskripsi_task" name="deskripsi_task" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('deskripsi_task', $task->deskripsi_task) }}</textarea>
            <x-ai-writing-assist context="task_description" target="deskripsi_task" />
        </x-form-field>
        @else
        <div class="rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800">
            Anda bisa memperbarui progres task Anda sendiri. Informasi inti task dikunci dan hanya bisa diubah oleh pembuat task atau admin.
        </div>
        <div class="grid gap-4 rounded-xl border border-gray-200 bg-gray-50 p-4 text-sm text-gray-700">
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">Program / Kegiatan</p>
                <p class="mt-1">{{ $task->kegiatan->programKerja->nama_program }} · {{ $task->kegiatan->nama_kegiatan }}</p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">Nama Task</p>
                <p class="mt-1">{{ $task->nama_task }}</p>
            </div>
            @if($task->deskripsi_task)
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">Deskripsi</p>
                <p class="mt-1">{{ $task->deskripsi_task }}</p>
            </div>
            @endif
        </div>
        @endif
        <div class="grid grid-cols-3 gap-4">
            <x-form-field label="Status" name="status" :required="true">
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @foreach($statuses as $s)
                    <option value="{{ $s->value }}" @selected(old('status', $task->status->value) === $s->value)>{{ $s->label() }}</option>
                    @endforeach
                </select>
            </x-form-field>
            @if($canManageTask)
            <x-form-field label="Prioritas" name="prioritas" :required="true">
                <select name="prioritas" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @foreach($priorities as $p)
                    <option value="{{ $p->value }}" @selected(old('prioritas', $task->prioritas->value) === $p->value)>{{ $p->label() }}</option>
                    @endforeach
                </select>
            </x-form-field>
            @else
            <x-form-field label="Prioritas" name="prioritas">
                <input type="text" value="{{ $task->prioritas->label() }}" disabled
                    class="w-full border border-gray-200 bg-gray-100 rounded-lg px-3 py-2 text-sm text-gray-500">
            </x-form-field>
            @endif
            <x-form-field label="Progress (%)" name="progress_persen" :required="true">
                <input type="number" name="progress_persen" value="{{ old('progress_persen', $task->progress_persen) }}" min="0" max="100"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </x-form-field>
        </div>
        @if($canManageTask)
        <x-form-field label="Due Date" name="due_date">
            <input type="date" name="due_date" value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </x-form-field>
        @else
        <x-form-field label="Due Date" name="due_date">
            <input type="text" value="{{ $task->due_date?->format('d M Y') ?? '-' }}" disabled
                class="w-full border border-gray-200 bg-gray-100 rounded-lg px-3 py-2 text-sm text-gray-500">
        </x-form-field>
        @endif
        <x-form-field label="Catatan Monev" name="catatan_monev">
            <textarea id="catatan_monev" name="catatan_monev" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('catatan_monev', $task->catatan_monev) }}</textarea>
            <x-ai-writing-assist context="task_monitoring_note" target="catatan_monev" />
        </x-form-field>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg">Simpan</button>
            <a href="{{ route('task.show', $task) }}" class="text-sm text-gray-600 px-5 py-2 rounded-lg border border-gray-300">Batal</a>
        </div>
    </form>
</div>
@endsection
