@extends('layouts.app')
@section('title', 'Semua Task')
@section('content')

@can('task.create')
<x-page-header title="Semua Task" action-label="Tambah Task" action-route="{{ route('task.create') }}" />
@endcan

<div class="card">
    <div class="card-header">
        <form method="GET" class="d-flex gap-2 flex-wrap w-100">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari task..."
                class="form-control form-control-sm w-auto">
            <select name="program_kerja_id" class="form-select form-select-sm w-auto">
                <option value="">Semua Program</option>
                @foreach($programs as $program)
                <option value="{{ $program->id }}" @selected((string) request('program_kerja_id') === (string) $program->id)>{{ $program->nama_program }}</option>
                @endforeach
            </select>
            <select name="status" class="form-select form-select-sm w-auto">
                <option value="">Semua Status</option>
                @foreach($statuses as $s)
                <option value="{{ $s->value }}" @selected(request('status') === $s->value)>{{ $s->label() }}</option>
                @endforeach
            </select>
            <select name="prioritas" class="form-select form-select-sm w-auto">
                <option value="">Semua Prioritas</option>
                @foreach($priorities as $p)
                <option value="{{ $p->value }}" @selected(request('prioritas') === $p->value)>{{ $p->label() }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-sm btn-outline-secondary">Filter</button>
            @if(request()->hasAny(['search', 'program_kerja_id', 'status', 'prioritas', 'kegiatan_id']))
            <a href="{{ route('task.index') }}" class="btn btn-sm btn-ghost-secondary">Reset</a>
            @endif
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-vcenter card-table">
            <thead>
                <tr>
                    <th>Task</th>
                    <th>Pelaksana</th>
                    <th>Due Date</th>
                    <th>Progress</th>
                    <th>Prioritas</th>
                    <th>Status</th>
                    <th class="w-1"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                <tr>
                    <td>
                        <a href="{{ route('task.show', $task) }}" class="fw-medium text-body">{{ $task->nama_task }}</a>
                        <div class="text-secondary small mt-1">{{ $task->kegiatan->programKerja->nama_program }} · {{ $task->kegiatan->nama_kegiatan }}</div>
                    </td>
                    <td>{{ $task->assignee->nama_pegawai }}</td>
                    <td class="{{ $task->due_date && $task->due_date->isPast() && $task->status->value !== 'done' ? 'text-danger fw-medium' : 'text-secondary' }} small">
                        {{ $task->due_date?->format('d M Y') ?? '-' }}
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="progress progress-sm flex-grow-1" style="min-width: 4rem">
                                <div class="progress-bar bg-primary" style="width: {{ $task->progress_persen }}%"></div>
                            </div>
                            <span class="text-secondary small">{{ $task->progress_persen }}%</span>
                        </div>
                    </td>
                    <td><x-badge-status :status="$task->prioritas->value">{{ $task->prioritas->label() }}</x-badge-status></td>
                    <td><x-badge-status :status="$task->status->value">{{ $task->status->label() }}</x-badge-status></td>
                    <td>
                        <div class="d-flex gap-1 justify-content-end">
                            @if(auth()->user()->can('task.edit') && $task->canBeUpdatedBy(auth()->user()))
                            <a href="{{ route('task.edit', $task) }}" class="btn btn-sm btn-icon btn-ghost-secondary" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/><path d="M16 5l3 3"/></svg>
                            </a>
                            @endif
                            @if(auth()->user()->can('task.delete') && $task->canBeManagedBy(auth()->user()))
                            <form method="POST" action="{{ route('task.destroy', $task) }}" onsubmit="return confirm('Hapus task ini?')">
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
                <tr><td colspan="7" class="text-center text-secondary py-5">Tidak ada task</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($tasks->hasPages())
    <div class="card-footer d-flex align-items-center">
        {{ $tasks->links() }}
    </div>
    @endif
</div>
@endsection
