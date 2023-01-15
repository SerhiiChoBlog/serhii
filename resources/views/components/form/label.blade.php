@php
    /**
     * @var string $id
     * @var bool|null $isRequired
     */
@endphp

<label class="flex items-center gap-1.5 leading-4 text-sm text-font-second font-bold mb-1" for="{{ $id }}">
    @if ($isRequired ?? false)
        <i class="text-red-500">*</i>
    @endif
    {{ $slot }}
</label>
