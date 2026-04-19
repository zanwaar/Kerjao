@extends('layouts.app')
@section('title', 'Edit GitHub Activity')
@section('content')
<x-page-header title="Edit GitHub Activity" />

<div class="max-w-2xl bg-white rounded-xl border border-gray-200 p-6">
    <form method="POST" action="{{ route('github-activity.update', $githubActivity) }}" class="space-y-4">
        @csrf @method('PUT')
        <x-form-field label="Task" name="task_id" :required="true">
            <select name="task_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @foreach($tasks as $task)
                <option value="{{ $task->id }}" @selected(old('task_id', $githubActivity->task_id) == $task->id)>{{ $task->kegiatan->nama_kegiatan }} · {{ $task->nama_task }}</option>
                @endforeach
            </select>
        </x-form-field>
        <x-form-field label="Pegawai" name="pegawai_id" :required="true">
            <select name="pegawai_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @foreach($pegawaiList as $p)
                <option value="{{ $p->id }}" @selected(old('pegawai_id', $githubActivity->pegawai_id) == $p->id)>{{ $p->nama_pegawai }}</option>
                @endforeach
            </select>
        </x-form-field>
        <div class="grid grid-cols-2 gap-4">
            <x-form-field label="Repository Name" name="repo_name" :required="true">
                <input type="text" name="repo_name" value="{{ old('repo_name', $githubActivity->repo_name) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </x-form-field>
            <x-form-field label="Branch" name="branch_name">
                <input type="text" name="branch_name" value="{{ old('branch_name', $githubActivity->branch_name) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </x-form-field>
        </div>
        <x-form-field label="Commit Message" name="commit_message">
            <input type="text" name="commit_message" value="{{ old('commit_message', $githubActivity->commit_message) }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </x-form-field>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg">Simpan</button>
            <a href="{{ route('github-activity.index') }}" class="text-sm text-gray-600 px-5 py-2 rounded-lg border border-gray-300">Batal</a>
        </div>
    </form>
</div>
@endsection
