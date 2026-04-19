@props(['label', 'name', 'required' => false])

<div {{ $attributes->only('class') }} class="mb-3">
    <label for="{{ $name }}" class="form-label">
        {{ $label }}
        @if($required)<span class="text-danger">*</span>@endif
    </label>

    {{ $slot }}

    @error($name)
    <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
