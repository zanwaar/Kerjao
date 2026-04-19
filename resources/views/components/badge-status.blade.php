@props(['status'])

@php
$classes = match($status) {
    'planning'              => 'bg-secondary-lt text-secondary',
    'active', 'aktif'       => 'bg-success-lt text-success',
    'completed', 'done'     => 'bg-success-lt text-success',
    'on_hold'               => 'bg-warning-lt text-warning',
    'canceled'              => 'bg-danger-lt text-danger',
    'not_started'           => 'bg-secondary-lt text-muted',
    'on_progress'           => 'bg-azure-lt text-azure',
    'high'                  => 'bg-danger-lt text-danger',
    'medium'                => 'bg-warning-lt text-warning',
    'low'                   => 'bg-secondary-lt text-secondary',
    'nonaktif'              => 'bg-danger-lt text-danger',
    default                 => 'bg-secondary-lt text-secondary',
};
@endphp

<span {{ $attributes->merge(['class' => "badge $classes"]) }}>{{ $slot }}</span>
