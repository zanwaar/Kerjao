@extends('layouts.app')
@section('title', 'Bukti Aktivitas')
@section('content')

@can('bukti-aktivitas.create')
<x-page-header title="Bukti Aktivitas" action-label="Tambah Bukti" action-route="{{ route('bukti-aktivitas.create') }}" />
@else
<x-page-header title="Bukti Aktivitas" />
@endcan

<div class="bg-white rounded-xl border border-gray-200">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-5 py-3 font-medium text-gray-600">Task</th>
                <th class="text-left px-5 py-3 font-medium text-gray-600">Pegawai</th>
                <th class="text-left px-5 py-3 font-medium text-gray-600">Jenis</th>
                <th class="text-left px-5 py-3 font-medium text-gray-600">Sumber</th>
                <th class="px-5 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($bukti as $b)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3">
                    <a href="{{ route('task.show', $b->task) }}" class="text-sm font-medium text-gray-800 hover:text-indigo-600">{{ $b->task->nama_task }}</a>
                    <p class="text-xs text-gray-400">{{ $b->task->kegiatan->nama_kegiatan }}</p>
                </td>
                <td class="px-5 py-3 text-gray-600">{{ $b->pegawai->nama_pegawai }}</td>
                <td class="px-5 py-3"><x-badge-status status="planning">{{ $b->jenis_bukti->label() }}</x-badge-status></td>
                <td class="px-5 py-3">
                    @if($b->jenis_bukti->value === 'link')
                    <a href="{{ $b->sumber_bukti }}" target="_blank" class="text-indigo-600 hover:underline text-sm truncate max-w-xs block">{{ $b->sumber_bukti }}</a>
                    @else
                    <span class="text-sm text-gray-700 truncate max-w-xs block">{{ $b->sumber_bukti }}</span>
                    @endif
                </td>
                <td class="px-5 py-3">
                    <div class="flex items-center gap-2 justify-end">
                        <a href="{{ route('bukti-aktivitas.edit', $b) }}" class="text-gray-400 hover:text-indigo-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form method="POST" action="{{ route('bukti-aktivitas.destroy', $b) }}" onsubmit="return confirm('Hapus bukti ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-5 py-10 text-center text-gray-400">Tidak ada bukti aktivitas</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($bukti->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">{{ $bukti->links() }}</div>
    @endif
</div>
@endsection
