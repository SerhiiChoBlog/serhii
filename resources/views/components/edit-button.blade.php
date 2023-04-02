@php
    /**
     * @var string $url
     */
@endphp

@if (auth('admin')->check())
    <a
        href="{{ $url }}"
        {{ $attributes->merge(['class' => 'transition-opacity opacity-70 hover:opacity-100 text-xs']) }}
    >
        EDIT
    </a>
@endif
