@extends('layouts.app')
@section('title', 'Edit GitHub Activity')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('github-activity.index') }}" class="btn btn-sm btn-ghost-secondary me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M15 6l-6 6l6 6"/></svg>
                </a>
                <h3 class="card-title">Edit GitHub Activity</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('github-activity.update', $githubActivity) }}">
                    @csrf @method('PUT')

                    <x-form-field label="Task" name="task_id" :required="true">
                        <select name="task_id" class="form-select @error('task_id') is-invalid @enderror">
                            @foreach($tasks as $task)
                            <option value="{{ $task->id }}" @selected(old('task_id', $githubActivity->task_id) == $task->id)>{{ $task->kegiatan->nama_kegiatan }} · {{ $task->nama_task }}</option>
                            @endforeach
                        </select>
                    </x-form-field>

                    <x-form-field label="Pegawai" name="pegawai_id" :required="true">
                        <select name="pegawai_id" class="form-select @error('pegawai_id') is-invalid @enderror">
                            @foreach($pegawaiList as $p)
                            <option value="{{ $p->id }}" @selected(old('pegawai_id', $githubActivity->pegawai_id) == $p->id)>{{ $p->nama_pegawai }}</option>
                            @endforeach
                        </select>
                    </x-form-field>

                    <div class="row">
                        <div class="col-md-6">
                            <x-form-field label="Repository Name" name="repo_name" :required="true">
                                <input type="text" name="repo_name" value="{{ old('repo_name', $githubActivity->repo_name) }}"
                                    class="form-control @error('repo_name') is-invalid @enderror">
                            </x-form-field>
                        </div>
                        <div class="col-md-6">
                            <x-form-field label="Branch" name="branch_name">
                                <input type="text" name="branch_name" value="{{ old('branch_name', $githubActivity->branch_name) }}" class="form-control">
                            </x-form-field>
                        </div>
                    </div>

                    <x-form-field label="Commit Message" name="commit_message">
                        <input type="text" name="commit_message" value="{{ old('commit_message', $githubActivity->commit_message) }}" class="form-control">
                    </x-form-field>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('github-activity.index') }}" class="btn btn-ghost-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
