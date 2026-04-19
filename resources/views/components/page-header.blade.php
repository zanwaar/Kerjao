@props(['title', 'action' => null, 'actionLabel' => null, 'actionRoute' => null])

@if($actionRoute)
<div class="d-flex justify-content-end mb-3">
    <a href="{{ $actionRoute }}" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon"><path d="M12 5l0 14"/><path d="M5 12l14 0"/></svg>
        {{ $actionLabel ?? 'Tambah' }}
    </a>
</div>
@endif
