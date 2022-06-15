@php
    $classes = 'bg-main text-white px-4 py-2 rounded-md transition-all hover:bg-main-hover shadow-md hover:shadow-lg';
@endphp

@if (isset($to))
    <a href="{{ $to }}" class="{{ $classes }}">
        {{ $slot }}
    </a>
@else
    <button type="{{ $type ?? 'submit' }}" class="{{ $classes }}">
        {{ $slot }}
    </button>
@endif
