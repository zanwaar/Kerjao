@extends('layouts.app')
@section('title', 'Tambah GitHub Activity')
@section('content')
<x-page-header title="Tambah GitHub Activity" />

<div class="max-w-2xl bg-white rounded-xl border border-gray-200 p-6">
    <form method="POST" action="{{ route('github-activity.store') }}" class="space-y-4">
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
            <x-form-field label="Repository Name" name="repo_name" :required="true">
                <input type="text" name="repo_name" value="{{ old('repo_name') }}" placeholder="owner/repo"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('repo_name') border-red-400 @enderror">
            </x-form-field>
            <x-form-field label="Branch" name="branch_name">
                <input type="text" name="branch_name" value="{{ old('branch_name') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </x-form-field>
        </div>
        <x-form-field label="Issue Link" name="issue_link">
            <input type="url" name="issue_link" value="{{ old('issue_link') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </x-form-field>
        <x-form-field label="PR Link" name="pr_link">
            <input type="url" name="pr_link" value="{{ old('pr_link') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </x-form-field>
        <div class="grid grid-cols-2 gap-4">
            <x-form-field label="Commit Hash" name="commit_hash">
                <input type="text" name="commit_hash" value="{{ old('commit_hash') }}" maxlength="40"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </x-form-field>
            <x-form-field label="Commit Time" name="commit_time">
                <input type="datetime-local" name="commit_time" value="{{ old('commit_time') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </x-form-field>
        </div>
        <x-form-field label="Commit Message" name="commit_message">
            <input type="text" name="commit_message" value="{{ old('commit_message') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </x-form-field>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg">Simpan</button>
            <a href="{{ route('github-activity.index') }}" class="text-sm text-gray-600 px-5 py-2 rounded-lg border border-gray-300">Batal</a>
        </div>
    </form>
</div>
@endsection
