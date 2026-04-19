@props(['title', 'action' => null, 'actionLabel' => null, 'actionRoute' => null])

<div class="flex items-center justify-between mb-6">
    <h2 class="text-lg font-semibold text-gray-800">{{ $title }}</h2>
    @if($action ?? $actionRoute)
    <a href="{{ $actionRoute }}"
       class="inline-flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        {{ $actionLabel ?? 'Tambah' }}
    </a>
    @endif
</div>
