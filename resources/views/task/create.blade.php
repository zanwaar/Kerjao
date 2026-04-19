@extends('layouts.app')
@section('title', 'Tambah Task')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('task.index') }}" class="btn btn-sm btn-ghost-secondary me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M15 6l-6 6l6 6"/></svg>
                </a>
                <h3 class="card-title">Tambah Task</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('task.store') }}">
                    @csrf

                    @if($kegiatan->isEmpty())
                    <div class="alert alert-warning mb-3">
                        Belum ada kegiatan yang bisa dipakai. Buat kegiatan Anda sendiri terlebih dahulu.
                    </div>
                    @endif

                    <x-form-field label="Kegiatan" name="kegiatan_id" :required="true">
                        <select name="kegiatan_id" class="form-select @error('kegiatan_id') is-invalid @enderror">
                            <option value="">-- Pilih Kegiatan --</option>
                            @foreach($kegiatan as $k)
                            <option value="{{ $k->id }}" @selected(old('kegiatan_id', $selectedKegiatan) == $k->id)>{{ $k->programKerja->nama_program }} · {{ $k->nama_kegiatan }}</option>
                            @endforeach
                        </select>
                    </x-form-field>

                    <x-form-field label="Pelaksana" name="assigned_to" :required="true">
                        <select name="assigned_to" class="form-select @error('assigned_to') is-invalid @enderror">
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach($pegawai as $p)
                            <option value="{{ $p->id }}" @selected(old('assigned_to') == $p->id)>{{ $p->nama_pegawai }} — {{ $p->jabatan }}</option>
                            @endforeach
                        </select>
                        @if($pegawai->count() === 1)
                        <div class="form-text">Pegawai hanya bisa membuat task untuk dirinya sendiri.</div>
                        @endif
                    </x-form-field>

                    <x-form-field label="Nama Task" name="nama_task" :required="true">
                        <input type="text" name="nama_task" value="{{ old('nama_task') }}"
                            class="form-control @error('nama_task') is-invalid @enderror">
                    </x-form-field>

                    <x-form-field label="Deskripsi" name="deskripsi_task">
                        <textarea id="deskripsi_task" name="deskripsi_task" rows="3" class="form-control">{{ old('deskripsi_task') }}</textarea>
                        <x-ai-writing-assist context="task_description" target="deskripsi_task" />
                    </x-form-field>

                    <div class="row">
                        <div class="col-md-4">
                            <x-form-field label="Status" name="status" :required="true">
                                <select name="status" class="form-select">
                                    @foreach($statuses as $s)
                                    <option value="{{ $s->value }}" @selected(old('status', 'not_started') === $s->value)>{{ $s->label() }}</option>
                                    @endforeach
                                </select>
                            </x-form-field>
                        </div>
                        <div class="col-md-4">
                            <x-form-field label="Prioritas" name="prioritas" :required="true">
                                <select name="prioritas" class="form-select">
                                    @foreach($priorities as $p)
                                    <option value="{{ $p->value }}" @selected(old('prioritas', 'medium') === $p->value)>{{ $p->label() }}</option>
                                    @endforeach
                                </select>
                            </x-form-field>
                        </div>
                        <div class="col-md-4">
                            <x-form-field label="Progress (%)" name="progress_persen" :required="true">
                                <input type="number" name="progress_persen" value="{{ old('progress_persen', 0) }}" min="0" max="100"
                                    class="form-control">
                            </x-form-field>
                        </div>
                    </div>

                    <x-form-field label="Due Date" name="due_date">
                        <input type="date" name="due_date" value="{{ old('due_date') }}" class="form-control">
                    </x-form-field>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" @disabled($kegiatan->isEmpty() || $pegawai->isEmpty()) class="btn btn-primary">Simpan</button>
                        <a href="{{ route('task.index') }}" class="btn btn-ghost-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
