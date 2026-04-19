@extends('layouts.app')
@section('title', 'Edit Task')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('task.show', $task) }}" class="btn btn-sm btn-ghost-secondary me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M15 6l-6 6l6 6"/></svg>
                </a>
                <h3 class="card-title">Edit Task</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('task.update', $task) }}">
                    @csrf @method('PUT')

                    @if($canManageTask)
                    <x-form-field label="Kegiatan" name="kegiatan_id" :required="true">
                        <select name="kegiatan_id" class="form-select">
                            @foreach($kegiatan as $k)
                            <option value="{{ $k->id }}" @selected(old('kegiatan_id', $task->kegiatan_id) == $k->id)>{{ $k->programKerja->nama_program }} · {{ $k->nama_kegiatan }}</option>
                            @endforeach
                        </select>
                    </x-form-field>

                    <x-form-field label="Pelaksana" name="assigned_to" :required="true">
                        <select name="assigned_to" class="form-select">
                            @foreach($pegawai as $p)
                            <option value="{{ $p->id }}" @selected(old('assigned_to', $task->assigned_to) == $p->id)>{{ $p->nama_pegawai }} — {{ $p->jabatan }}</option>
                            @endforeach
                        </select>
                    </x-form-field>

                    <x-form-field label="Nama Task" name="nama_task" :required="true">
                        <input type="text" name="nama_task" value="{{ old('nama_task', $task->nama_task) }}"
                            class="form-control @error('nama_task') is-invalid @enderror">
                    </x-form-field>

                    <x-form-field label="Deskripsi" name="deskripsi_task">
                        <textarea id="deskripsi_task" name="deskripsi_task" rows="3" class="form-control">{{ old('deskripsi_task', $task->deskripsi_task) }}</textarea>
                        <x-ai-writing-assist context="task_description" target="deskripsi_task" />
                    </x-form-field>
                    @else
                    <div class="alert alert-info mb-3">
                        Anda bisa memperbarui progres task Anda sendiri. Informasi inti task dikunci dan hanya bisa diubah oleh pembuat task atau admin.
                    </div>
                    <div class="card bg-light border-0 mb-3">
                        <div class="card-body">
                            <div class="mb-2">
                                <div class="text-secondary small fw-medium">Program / Kegiatan</div>
                                <div>{{ $task->kegiatan->programKerja->nama_program }} · {{ $task->kegiatan->nama_kegiatan }}</div>
                            </div>
                            <div class="mb-2">
                                <div class="text-secondary small fw-medium">Nama Task</div>
                                <div>{{ $task->nama_task }}</div>
                            </div>
                            @if($task->deskripsi_task)
                            <div>
                                <div class="text-secondary small fw-medium">Deskripsi</div>
                                <div>{{ $task->deskripsi_task }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4">
                            <x-form-field label="Status" name="status" :required="true">
                                <select name="status" class="form-select">
                                    @foreach($statuses as $s)
                                    <option value="{{ $s->value }}" @selected(old('status', $task->status->value) === $s->value)>{{ $s->label() }}</option>
                                    @endforeach
                                </select>
                            </x-form-field>
                        </div>
                        <div class="col-md-4">
                            @if($canManageTask)
                            <x-form-field label="Prioritas" name="prioritas" :required="true">
                                <select name="prioritas" class="form-select">
                                    @foreach($priorities as $p)
                                    <option value="{{ $p->value }}" @selected(old('prioritas', $task->prioritas->value) === $p->value)>{{ $p->label() }}</option>
                                    @endforeach
                                </select>
                            </x-form-field>
                            @else
                            <x-form-field label="Prioritas" name="prioritas">
                                <input type="text" value="{{ $task->prioritas->label() }}" disabled class="form-control">
                            </x-form-field>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <x-form-field label="Progress (%)" name="progress_persen" :required="true">
                                <input type="number" name="progress_persen" value="{{ old('progress_persen', $task->progress_persen) }}" min="0" max="100"
                                    class="form-control">
                            </x-form-field>
                        </div>
                    </div>

                    @if($canManageTask)
                    <x-form-field label="Due Date" name="due_date">
                        <input type="date" name="due_date" value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}" class="form-control">
                    </x-form-field>
                    @else
                    <x-form-field label="Due Date" name="due_date">
                        <input type="text" value="{{ $task->due_date?->format('d M Y') ?? '-' }}" disabled class="form-control">
                    </x-form-field>
                    @endif

                    <x-form-field label="Catatan Monev" name="catatan_monev">
                        <textarea id="catatan_monev" name="catatan_monev" rows="2" class="form-control">{{ old('catatan_monev', $task->catatan_monev) }}</textarea>
                        <x-ai-writing-assist context="task_monitoring_note" target="catatan_monev" />
                    </x-form-field>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('task.show', $task) }}" class="btn btn-ghost-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
