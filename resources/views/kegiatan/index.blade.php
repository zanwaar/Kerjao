@extends('layouts.app')
@section('title', 'Kegiatan')
@section('content')

@can('kegiatan.create')
<x-page-header title="Kegiatan" action-label="Tambah Kegiatan" action-route="{{ route('kegiatan.create') }}" />
@endcan

<div class="card">
    <div class="card-header">
        <form method="GET" class="d-flex gap-2 flex-wrap w-100">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kegiatan..."
                class="form-control form-control-sm w-auto">
            <select name="program_kerja_id" class="form-select form-select-sm w-auto">
                <option value="">Semua Program</option>
                @foreach($programs as $p)
                <option value="{{ $p->id }}" @selected(request('program_kerja_id') == $p->id)>{{ $p->nama_program }}</option>
                @endforeach
            </select>
            <select name="status" class="form-select form-select-sm w-auto">
                <option value="">Semua Status</option>
                @foreach($statuses as $s)
                <option value="{{ $s->value }}" @selected(request('status') === $s->value)>{{ $s->label() }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-sm btn-outline-secondary">Filter</button>
            @if(request()->hasAny(['search', 'status', 'program_kerja_id']))
            <a href="{{ route('kegiatan.index') }}" class="btn btn-sm btn-ghost-secondary">Reset</a>
            @endif
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-vcenter card-table">
            <thead>
                <tr>
                    <th>Kegiatan</th>
                    <th>Program</th>
                    <th>Periode</th>
                    <th>Task</th>
                    <th>Status</th>
                    <th class="w-1"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($kegiatan as $k)
                <tr>
                    <td>
                        <a href="{{ route('kegiatan.show', $k) }}" class="fw-medium text-body">{{ $k->nama_kegiatan }}</a>
                    </td>
                    <td class="text-secondary small">{{ $k->programKerja->nama_program }}</td>
                    <td class="text-secondary small">
                        {{ $k->waktu_mulai->format('d M Y') }}<br>
                        {{ $k->waktu_selesai->format('d M Y') }}
                    </td>
                    <td>{{ $k->tasks_count }}</td>
                    <td><x-badge-status :status="$k->status_kegiatan->value">{{ $k->status_kegiatan->label() }}</x-badge-status></td>
                    <td>
                        <div class="d-flex gap-1 justify-content-end">
                            @if(auth()->user()->can('kegiatan.edit') && $k->canBeManagedBy(auth()->user()))
                            <a href="{{ route('kegiatan.edit', $k) }}" class="btn btn-sm btn-icon btn-ghost-secondary" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/><path d="M16 5l3 3"/></svg>
                            </a>
                            @endif
                            @if(auth()->user()->can('kegiatan.delete') && $k->canBeManagedBy(auth()->user()))
                            <form method="POST" action="{{ route('kegiatan.destroy', $k) }}" onsubmit="return confirm('Hapus kegiatan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-icon btn-ghost-danger" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M4 7l16 0"/><path d="M10 11l0 6"/><path d="M14 11l0 6"/><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-secondary py-5">Tidak ada data kegiatan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($kegiatan->hasPages())
    <div class="card-footer d-flex align-items-center">
        {{ $kegiatan->links() }}
    </div>
    @endif
</div>
@endsection
