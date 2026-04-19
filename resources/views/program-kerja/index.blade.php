@extends('layouts.app')
@section('title', 'Program Kerja')
@section('content')

@can('program-kerja.create')
<x-page-header title="Program Kerja" action-label="Tambah Program" action-route="{{ route('program-kerja.create') }}" />
@endcan

<div class="card">
    <div class="card-header">
        <form method="GET" class="d-flex gap-2 flex-wrap w-100">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama program..."
                class="form-control form-control-sm w-auto">
            <select name="status" class="form-select form-select-sm w-auto">
                <option value="">Semua Status</option>
                @foreach($statuses as $s)
                <option value="{{ $s->value }}" @selected(request('status') === $s->value)>{{ $s->label() }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-sm btn-outline-secondary">Filter</button>
            @if(request()->hasAny(['search', 'status']))
            <a href="{{ route('program-kerja.index') }}" class="btn btn-sm btn-ghost-secondary">Reset</a>
            @endif
        </form>
    </div>

    <div class="list-group list-group-flush">
        @forelse($programs as $program)
        <div class="list-group-item">
            <div class="row align-items-center">
                <div class="col">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <a href="{{ route('program-kerja.show', $program) }}" class="text-body fw-medium">{{ $program->nama_program }}</a>
                        <x-badge-status :status="$program->status_program->value">{{ $program->status_program->label() }}</x-badge-status>
                    </div>
                    <div class="text-secondary small mt-1">
                        {{ $program->waktu_mulai->format('d M Y') }} — {{ $program->waktu_selesai->format('d M Y') }}
                        · {{ $program->kegiatan_count }} kegiatan
                        · Oleh {{ $program->creator->name }}
                    </div>
                    @if($program->deskripsi)
                    <div class="text-secondary small mt-1 text-truncate">{{ $program->deskripsi }}</div>
                    @endif
                </div>
                @if(auth()->user()->can('program-kerja.edit') && $program->canBeManagedBy(auth()->user()))
                <div class="col-auto d-flex gap-1">
                    <a href="{{ route('program-kerja.edit', $program) }}" class="btn btn-sm btn-icon btn-ghost-secondary" title="Edit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/><path d="M16 5l3 3"/></svg>
                    </a>
                    @if(auth()->user()->can('program-kerja.delete'))
                    <form method="POST" action="{{ route('program-kerja.destroy', $program) }}" onsubmit="return confirm('Hapus program ini? Semua kegiatan terkait akan ikut terhapus.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-icon btn-ghost-danger" title="Hapus">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M4 7l16 0"/><path d="M10 11l0 6"/><path d="M14 11l0 6"/><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/></svg>
                        </button>
                    </form>
                    @endif
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="list-group-item text-center text-secondary py-5">Belum ada program kerja</div>
        @endforelse
    </div>

    @if($programs->hasPages())
    <div class="card-footer d-flex align-items-center">
        {{ $programs->links() }}
    </div>
    @endif
</div>
@endsection
