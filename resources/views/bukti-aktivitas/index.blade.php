@extends('layouts.app')
@section('title', 'Bukti Aktivitas')
@section('content')

@can('bukti-aktivitas.create')
<x-page-header title="Bukti Aktivitas" action-label="Tambah Bukti" action-route="{{ route('bukti-aktivitas.create') }}" />
@endcan

<div class="card">
    <div class="table-responsive">
        <table class="table table-vcenter card-table">
            <thead>
                <tr>
                    <th>Task</th>
                    <th>Pegawai</th>
                    <th>Jenis</th>
                    <th>Sumber</th>
                    <th class="w-1"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($bukti as $b)
                <tr>
                    <td>
                        <a href="{{ route('task.show', $b->task) }}" class="fw-medium text-body">{{ $b->task->nama_task }}</a>
                        <div class="text-secondary small">{{ $b->task->kegiatan->nama_kegiatan }}</div>
                    </td>
                    <td>{{ $b->pegawai->nama_pegawai }}</td>
                    <td><x-badge-status status="planning">{{ $b->jenis_bukti->label() }}</x-badge-status></td>
                    <td>
                        @if($b->jenis_bukti->value === 'link')
                        <a href="{{ $b->sumber_bukti }}" target="_blank" class="text-primary text-truncate d-block" style="max-width: 300px">{{ $b->sumber_bukti }}</a>
                        @else
                        <span class="text-body text-truncate d-block" style="max-width: 300px">{{ $b->sumber_bukti }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1 justify-content-end">
                            <a href="{{ route('bukti-aktivitas.edit', $b) }}" class="btn btn-sm btn-icon btn-ghost-secondary" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/><path d="M16 5l3 3"/></svg>
                            </a>
                            <form method="POST" action="{{ route('bukti-aktivitas.destroy', $b) }}" onsubmit="return confirm('Hapus bukti ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-icon btn-ghost-danger" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M4 7l16 0"/><path d="M10 11l0 6"/><path d="M14 11l0 6"/><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-secondary py-5">Tidak ada bukti aktivitas</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($bukti->hasPages())
    <div class="card-footer d-flex align-items-center">
        {{ $bukti->links() }}
    </div>
    @endif
</div>
@endsection
