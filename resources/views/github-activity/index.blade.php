@extends('layouts.app')
@section('title', 'GitHub Activity')
@section('content')

@can('github-activity.create')
<x-page-header title="GitHub Activity" action-label="Tambah" action-route="{{ route('github-activity.create') }}" />
@endcan

<div class="card">
    <div class="table-responsive">
        <table class="table table-vcenter card-table">
            <thead>
                <tr>
                    <th>Repo / Branch</th>
                    <th>Task</th>
                    <th>Pegawai</th>
                    <th>Commit</th>
                    <th class="w-1"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($activities as $act)
                <tr>
                    <td>
                        <div class="fw-medium">{{ $act->repo_name }}</div>
                        @if($act->branch_name)<div class="text-secondary small">{{ $act->branch_name }}</div>@endif
                    </td>
                    <td class="text-secondary small">{{ $act->task->nama_task }}</td>
                    <td>{{ $act->pegawai->nama_pegawai }}</td>
                    <td>
                        @if($act->commit_message)
                        <div class="text-truncate" style="max-width: 250px">{{ $act->commit_message }}</div>
                        @if($act->commit_hash)<div class="text-secondary small font-monospace">{{ substr($act->commit_hash, 0, 7) }}</div>@endif
                        @else<span class="text-secondary">-</span>@endif
                    </td>
                    <td>
                        <div class="d-flex gap-1 justify-content-end">
                            <a href="{{ route('github-activity.edit', $act) }}" class="btn btn-sm btn-icon btn-ghost-secondary" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/><path d="M16 5l3 3"/></svg>
                            </a>
                            <form method="POST" action="{{ route('github-activity.destroy', $act) }}" onsubmit="return confirm('Hapus activity ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-icon btn-ghost-danger" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M4 7l16 0"/><path d="M10 11l0 6"/><path d="M14 11l0 6"/><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-secondary py-5">Tidak ada GitHub activity</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($activities->hasPages())
    <div class="card-footer d-flex align-items-center">
        {{ $activities->links() }}
    </div>
    @endif
</div>
@endsection
