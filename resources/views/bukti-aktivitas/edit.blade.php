@extends('layouts.app')
@section('title', 'Edit Bukti Aktivitas')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('bukti-aktivitas.index') }}" class="btn btn-sm btn-ghost-secondary me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M15 6l-6 6l6 6"/></svg>
                </a>
                <h3 class="card-title">Edit Bukti Aktivitas</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('bukti-aktivitas.update', $buktiAktivita) }}">
                    @csrf @method('PUT')

                    <x-form-field label="Task" name="task_id" :required="true">
                        <select name="task_id" class="form-select @error('task_id') is-invalid @enderror">
                            @foreach($tasks as $task)
                            <option value="{{ $task->id }}" @selected(old('task_id', $buktiAktivita->task_id) == $task->id)>{{ $task->kegiatan->nama_kegiatan }} · {{ $task->nama_task }}</option>
                            @endforeach
                        </select>
                    </x-form-field>

                    <x-form-field label="Pegawai" name="pegawai_id" :required="true">
                        <select name="pegawai_id" class="form-select @error('pegawai_id') is-invalid @enderror">
                            @foreach($pegawaiList as $p)
                            <option value="{{ $p->id }}" @selected(old('pegawai_id', $buktiAktivita->pegawai_id) == $p->id)>{{ $p->nama_pegawai }}</option>
                            @endforeach
                        </select>
                    </x-form-field>

                    <x-form-field label="Jenis Bukti" name="jenis_bukti" :required="true">
                        <select name="jenis_bukti" class="form-select @error('jenis_bukti') is-invalid @enderror">
                            @foreach($jenisList as $j)
                            <option value="{{ $j->value }}" @selected(old('jenis_bukti', $buktiAktivita->jenis_bukti->value) === $j->value)>{{ $j->label() }}</option>
                            @endforeach
                        </select>
                    </x-form-field>

                    <x-form-field label="Sumber Bukti" name="sumber_bukti" :required="true">
                        <input type="text" name="sumber_bukti" value="{{ old('sumber_bukti', $buktiAktivita->sumber_bukti) }}"
                            class="form-control @error('sumber_bukti') is-invalid @enderror">
                    </x-form-field>

                    <x-form-field label="Keterangan" name="keterangan">
                        <textarea name="keterangan" rows="2" class="form-control">{{ old('keterangan', $buktiAktivita->keterangan) }}</textarea>
                    </x-form-field>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('bukti-aktivitas.index') }}" class="btn btn-ghost-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
