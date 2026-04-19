@props(['status'])

@php
$classes = match($status) {
    'planning' => 'bg-gray-100 text-gray-700',
    'active' => 'bg-blue-100 text-blue-700',
    'completed', 'done' => 'bg-green-100 text-green-700',
    'on_hold', 'canceled' => 'bg-red-100 text-red-700',
    'not_started' => 'bg-gray-100 text-gray-600',
    'on_progress' => 'bg-yellow-100 text-yellow-700',
    default => 'bg-gray-100 text-gray-600',
};
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2 py-0.5 rounded text-xs font-medium $classes"]) }}>
    {{ $slot }}
</span>
