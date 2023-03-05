@php
    /**
     * @var string $slot
     * @var string $ariaLabel
     */
@endphp

<span aria-label="{{ $ariaLabel }}" class="flex items-center gap-0.5 text-sm">
    {{ $slot }}
</span>
