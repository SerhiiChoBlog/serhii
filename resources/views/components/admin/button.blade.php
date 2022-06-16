@php
    $classes = 'inline-block bg-main uppercase text-white text-sm px-6 py-2 rounded-full transition-all hover:bg-main-hover shadow-md hover:shadow-lg';
@endphp

@if (isset($to))
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
