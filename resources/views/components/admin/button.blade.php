@php
    $classes = 'bg-main uppercase text-white text-sm px-6 py-3 rounded-md transition-all hover:bg-main-hover shadow-md hover:shadow-lg';
@endphp

@if (isset($to))
    <a href="{{ $to }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type ?? 'submit' }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
