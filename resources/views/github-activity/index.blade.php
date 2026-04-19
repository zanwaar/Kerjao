@extends('layouts.app')
@section('title', 'GitHub Activity')
@section('content')

@can('github-activity.create')
<x-page-header title="GitHub Activity" action-label="Tambah" action-route="{{ route('github-activity.create') }}" />
@else
<x-page-header title="GitHub Activity" />
@endcan

<div class="bg-white rounded-xl border border-gray-200">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-5 py-3 font-medium text-gray-600">Repo / Branch</th>
                <th class="text-left px-5 py-3 font-medium text-gray-600">Task</th>
                <th class="text-left px-5 py-3 font-medium text-gray-600">Pegawai</th>
                <th class="text-left px-5 py-3 font-medium text-gray-600">Commit</th>
                <th class="px-5 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($activities as $act)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3">
                    <p class="font-medium text-gray-800">{{ $act->repo_name }}</p>
                    @if($act->branch_name)<p class="text-xs text-gray-400">{{ $act->branch_name }}</p>@endif
                </td>
                <td class="px-5 py-3 text-gray-600 text-xs">{{ $act->task->nama_task }}</td>
                <td class="px-5 py-3 text-gray-600">{{ $act->pegawai->nama_pegawai }}</td>
                <td class="px-5 py-3">
                    @if($act->commit_message)
                    <p class="text-xs text-gray-700 truncate max-w-xs">{{ $act->commit_message }}</p>
                    @if($act->commit_hash)<p class="text-xs text-gray-400 font-mono">{{ substr($act->commit_hash, 0, 7) }}</p>@endif
                    @else<span class="text-gray-400">-</span>@endif
                </td>
                <td class="px-5 py-3">
                    <div class="flex items-center gap-2 justify-end">
                        <a href="{{ route('github-activity.edit', $act) }}" class="text-gray-400 hover:text-indigo-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form method="POST" action="{{ route('github-activity.destroy', $act) }}" onsubmit="return confirm('Hapus?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-5 py-10 text-center text-gray-400">Tidak ada GitHub activity</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($activities->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">{{ $activities->links() }}</div>
    @endif
</div>
@endsection
