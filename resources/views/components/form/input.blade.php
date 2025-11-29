@php
    /**
     * @var string $name
     * @var string|null $type
     * @var string|null $placeholder
     * @var string|null $value
     * @var string|null $id
     */
@endphp

<div class="relative">
    <input
        type="{{ $type ?? 'text' }}"
        placeholder="{{ $placeholder ?? '' }}"
        class="w-full px-4 py-3 border bg-page-second rounded-md focus:outline-hidden focus:ring-1 focus:ring-main @error($name) border-red-600/50 @else border-border @enderror"
        name="{{ $name }}"
        value="{{ $value ?? '' }}"
        id="{{ $id ?? '' }}"
        ref="ref-{{ $name }}"
    >

    @if (isset($type) && $type === 'password')
        <show-password-button input-id="{{ $id ?? '' }}"></show-password-button>
    @endif
</div>

@error($name)
    <x-form.validation-message :message="$message" />
@enderror
