@extends('layouts.app')
@section('title', 'Task Saya')
@section('content')

<x-page-header title="Task Saya" />

@if(!$pegawai)
<div class="bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-lg p-4 text-sm">
    Akun Anda belum terhubung ke data pegawai. Hubungi admin untuk menghubungkan.
</div>
@else

<div class="bg-white rounded-xl border border-gray-200">
    <form method="GET" class="px-5 py-4 border-b border-gray-100 flex gap-3">
        <select name="status" class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="">Semua Status</option>
            @foreach($statuses as $s)
            <option value="{{ $s->value }}" @selected(request('status') === $s->value)>{{ $s->label() }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm px-4 py-1.5 rounded-lg">Filter</button>
    </form>

    <div class="divide-y divide-gray-50">
        @forelse($tasks as $task)
        <div class="px-5 py-4 hover:bg-gray-50">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2 flex-wrap">
                        <a href="{{ route('task.show', $task) }}" class="font-medium text-gray-800 hover:text-indigo-600">{{ $task->nama_task }}</a>
                        <x-badge-status :status="$task->prioritas->value">{{ $task->prioritas->label() }}</x-badge-status>
                        <x-badge-status :status="$task->status->value">{{ $task->status->label() }}</x-badge-status>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">{{ $task->kegiatan->programKerja->nama_program }} · {{ $task->kegiatan->nama_kegiatan }}</p>
                    @if($task->due_date)
                    <p class="text-xs mt-1 {{ $task->due_date->isPast() && $task->status->value !== 'done' ? 'text-red-600 font-medium' : 'text-gray-400' }}">
                        Due: {{ $task->due_date->format('d M Y') }}
                    </p>
                    @endif
                </div>
                <div class="text-right shrink-0">
                    <p class="text-2xl font-bold text-indigo-600">{{ $task->progress_persen }}<span class="text-sm font-normal text-gray-400">%</span></p>
                    <div class="flex gap-2 mt-2">
                        <a href="{{ route('daily-scrum.create') }}?task_id={{ $task->id }}" class="text-xs text-indigo-600 hover:underline">+ Scrum</a>
                        <a href="{{ route('bukti-aktivitas.create') }}?task_id={{ $task->id }}" class="text-xs text-gray-500 hover:underline">+ Bukti</a>
                    </div>
                </div>
            </div>
            <div class="mt-3 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-indigo-500 rounded-full transition-all" style="width: {{ $task->progress_persen }}%"></div>
            </div>
        </div>
        @empty
        <div class="px-5 py-12 text-center text-gray-400">Tidak ada task yang di-assign ke Anda</div>
        @endforelse
    </div>
    @if($tasks->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">{{ $tasks->links() }}</div>
    @endif
</div>
@endif
@endsection
