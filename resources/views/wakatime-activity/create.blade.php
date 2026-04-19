@extends('layouts.app')
@section('title', 'Tambah WakaTime Activity')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('wakatime-activity.index') }}" class="btn btn-sm btn-ghost-secondary me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M15 6l-6 6l6 6"/></svg>
                </a>
                <h3 class="card-title">Tambah WakaTime Activity</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('wakatime-activity.store') }}">
                    @csrf

                    <x-form-field label="Task" name="task_id" :required="true">
                        <select name="task_id" class="form-select @error('task_id') is-invalid @enderror">
                            <option value="">-- Pilih Task --</option>
                            @foreach($tasks as $task)
                            <option value="{{ $task->id }}" @selected(old('task_id', $selectedTask) == $task->id)>{{ $task->kegiatan->nama_kegiatan }} · {{ $task->nama_task }}</option>
                            @endforeach
                        </select>
                    </x-form-field>

                    <x-form-field label="Pegawai" name="pegawai_id" :required="true">
                        <select name="pegawai_id" class="form-select @error('pegawai_id') is-invalid @enderror">
                            @foreach($pegawaiList as $p)
                            <option value="{{ $p->id }}" @selected(old('pegawai_id', $pegawaiUser?->id) == $p->id)>{{ $p->nama_pegawai }}</option>
                            @endforeach
                        </select>
                    </x-form-field>

                    <div class="row">
                        <div class="col-md-6">
                            <x-form-field label="Tanggal" name="activity_date" :required="true">
                                <input type="date" name="activity_date" value="{{ old('activity_date', today()->format('Y-m-d')) }}"
                                    class="form-control @error('activity_date') is-invalid @enderror">
                            </x-form-field>
                        </div>
                        <div class="col-md-6">
                            <x-form-field label="Durasi (jam)" name="duration_hours" :required="true">
                                <input type="number" name="duration_hours" value="{{ old('duration_hours', 1) }}" min="0" max="24" step="0.25"
                                    class="form-control @error('duration_hours') is-invalid @enderror">
                            </x-form-field>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <x-form-field label="Project Name" name="project_name" :required="true">
                                <input type="text" name="project_name" value="{{ old('project_name') }}"
                                    class="form-control @error('project_name') is-invalid @enderror">
                            </x-form-field>
                        </div>
                        <div class="col-md-6">
                            <x-form-field label="Language" name="language_name">
                                <input type="text" name="language_name" value="{{ old('language_name') }}" placeholder="PHP, JS, dll"
                                    class="form-control">
                            </x-form-field>
                        </div>
                    </div>

                    <x-form-field label="Deskripsi" name="description">
                        <textarea name="description" rows="2" class="form-control">{{ old('description') }}</textarea>
                    </x-form-field>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('wakatime-activity.index') }}" class="btn btn-ghost-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
