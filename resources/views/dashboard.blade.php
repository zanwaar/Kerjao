@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wide">{{ $canViewAllTasks ? 'Program Aktif' : 'Program Saya' }}</p>
        <p class="text-2xl font-bold text-indigo-600 mt-1">{{ $totalProgramAktif }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wide">{{ $canViewAllTasks ? 'Kegiatan Aktif' : 'Kegiatan Saya' }}</p>
        <p class="text-2xl font-bold text-blue-600 mt-1">{{ $totalKegiatanAktif }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wide">{{ $canViewAllTasks ? 'Total Task' : 'Task Saya' }}</p>
        <p class="text-2xl font-bold text-gray-700 mt-1">{{ $totalTask }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Task Selesai</p>
        <p class="text-2xl font-bold text-green-600 mt-1">{{ $taskSelesai }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wide">On Progress</p>
        <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $taskOnProgress }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Task Overdue --}}
    <div class="bg-white rounded-xl border border-gray-200">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-semibold text-gray-800">{{ $canViewAllTasks ? 'Task Overdue' : 'Task Saya Terlambat' }}</h2>
            <span class="text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded-full font-medium">{{ $taskOverdue->count() }}</span>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($taskOverdue as $task)
            <div class="px-5 py-3 flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <a href="{{ route('task.show', $task) }}" class="text-sm font-medium text-gray-800 hover:text-indigo-600 truncate block">
                        {{ $task->nama_task }}
                    </a>
                    <p class="text-xs text-gray-400 mt-0.5">
                        {{ $task->kegiatan->programKerja->nama_program }} · {{ $task->kegiatan->nama_kegiatan }}
                        @if($canViewAllTasks && $task->assignee)
                        · {{ $task->assignee->nama_pegawai }}
                        @endif
                    </p>
                </div>
                <span class="shrink-0 text-xs text-red-600 font-medium">{{ $task->due_date?->format('d M') }}</span>
            </div>
            @empty
            <div class="px-5 py-8 text-center text-sm text-gray-400">Tidak ada task overdue</div>
            @endforelse
        </div>
    </div>

    {{-- Kanan: Task Saya + Scrum hari ini --}}
    <div class="space-y-6">
        {{-- Task Saya --}}
        @if($taskSaya->isNotEmpty())
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-semibold text-gray-800">Task Saya</h2>
                <a href="{{ route('task.saya') }}" class="text-xs text-indigo-600 hover:underline">Lihat semua</a>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach($taskSaya as $task)
                <div class="px-5 py-3">
                    <div class="flex items-center justify-between gap-2 mb-1">
                        <a href="{{ route('task.show', $task) }}" class="text-sm font-medium text-gray-800 hover:text-indigo-600 truncate">
                            {{ $task->nama_task }}
                        </a>
                        <span class="shrink-0 text-xs px-2 py-0.5 rounded-full
                            {{ $task->prioritas->value === 'high' ? 'bg-red-100 text-red-700' : ($task->prioritas->value === 'medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-600') }}">
                            {{ $task->prioritas->label() }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-500 rounded-full" style="width: {{ $task->progress_persen }}%"></div>
                        </div>
                        <span class="text-xs text-gray-400 shrink-0">{{ $task->progress_persen }}%</span>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">{{ $task->kegiatan->programKerja->nama_program }} · {{ $task->kegiatan->nama_kegiatan }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Scrum Hari Ini --}}
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-semibold text-gray-800">Scrum Hari Ini</h2>
                <a href="{{ route('daily-scrum.create') }}" class="text-xs bg-indigo-600 text-white px-3 py-1 rounded-lg hover:bg-indigo-700">+ Tambah</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($scrumHariIni as $scrum)
                <div class="px-5 py-3">
                    <p class="text-sm font-medium text-gray-800 truncate">{{ $scrum->task->nama_task }}</p>
                    <p class="text-xs text-gray-500 mt-0.5 line-clamp-2">{{ $scrum->rencana_kerja_harian }}</p>
                </div>
                @empty
                <div class="px-5 py-8 text-center">
                    <p class="text-sm text-gray-400">Belum ada scrum hari ini</p>
                    <a href="{{ route('daily-scrum.create') }}" class="mt-2 inline-block text-sm text-indigo-600 hover:underline">Isi sekarang</a>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
