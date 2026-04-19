@extends('layouts.app')
@section('title', 'Edit Bukti Aktivitas')
@section('content')
<x-page-header title="Edit Bukti Aktivitas" />

<div class="max-w-2xl bg-white rounded-xl border border-gray-200 p-6">
    <form method="POST" action="{{ route('bukti-aktivitas.update', $buktiAktivita) }}" class="space-y-4">
        @csrf @method('PUT')
        <x-form-field label="Task" name="task_id" :required="true">
            <select name="task_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @foreach($tasks as $task)
                <option value="{{ $task->id }}" @selected(old('task_id', $buktiAktivita->task_id) == $task->id)>{{ $task->kegiatan->nama_kegiatan }} · {{ $task->nama_task }}</option>
                @endforeach
            </select>
        </x-form-field>
        <x-form-field label="Pegawai" name="pegawai_id" :required="true">
            <select name="pegawai_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @foreach($pegawaiList as $p)
                <option value="{{ $p->id }}" @selected(old('pegawai_id', $buktiAktivita->pegawai_id) == $p->id)>{{ $p->nama_pegawai }}</option>
                @endforeach
            </select>
        </x-form-field>
        <x-form-field label="Jenis Bukti" name="jenis_bukti" :required="true">
            <select name="jenis_bukti" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @foreach($jenisList as $j)
                <option value="{{ $j->value }}" @selected(old('jenis_bukti', $buktiAktivita->jenis_bukti->value) === $j->value)>{{ $j->label() }}</option>
                @endforeach
            </select>
        </x-form-field>
        <x-form-field label="Sumber Bukti" name="sumber_bukti" :required="true">
            <input type="text" name="sumber_bukti" value="{{ old('sumber_bukti', $buktiAktivita->sumber_bukti) }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </x-form-field>
        <x-form-field label="Keterangan" name="keterangan">
            <textarea name="keterangan" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('keterangan', $buktiAktivita->keterangan) }}</textarea>
        </x-form-field>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg">Simpan</button>
            <a href="{{ route('bukti-aktivitas.index') }}" class="text-sm text-gray-600 px-5 py-2 rounded-lg border border-gray-300">Batal</a>
        </div>
    </form>
</div>
@endsection
