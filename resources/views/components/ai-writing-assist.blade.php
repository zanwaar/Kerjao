@props([
    'context',
    'target',
])

<div class="mt-2 d-flex align-items-center gap-2">
    <button
        type="button"
        data-ai-writing-button
        data-context="{{ $context }}"
        data-target="{{ $target }}"
        data-url="{{ route('ai-writing-assist.improve') }}"
        class="btn btn-sm btn-outline-primary"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2"><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"/><path d="M12 9l0 4"/><path d="M12 16l.01 0"/></svg>
        Perbaiki dengan AI
    </button>
    <span data-ai-writing-status="{{ $target }}" class="text-secondary small"></span>
</div>
