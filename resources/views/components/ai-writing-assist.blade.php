@props([
    'context',
    'target',
])

<div class="mt-2 flex items-center gap-3 text-xs">
    <button
        type="button"
        data-ai-writing-button
        data-context="{{ $context }}"
        data-target="{{ $target }}"
        data-url="{{ route('ai-writing-assist.improve') }}"
        class="inline-flex items-center rounded-lg border border-indigo-200 bg-indigo-50 px-3 py-1.5 font-medium text-indigo-700 transition hover:border-indigo-300 hover:bg-indigo-100"
    >
        Perbaiki dengan AI
    </button>
    <span data-ai-writing-status="{{ $target }}" class="text-gray-500"></span>
</div>
