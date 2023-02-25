@php
    use Illuminate\View\ComponentAttributeBag;

    /**
     * @var int $amount
     * @var ComponentAttributeBag $attributes
     */
@endphp

@if ($amount > 0)
    <span
        {{ $attributes->merge(['class' => 'flex items-center gap-0.5']) }}
        aria-label="Post comments amount"
        title="Post comments amount"
    >
        <x-icons.comment class="w-5 h-5"/>
        {{ $amount }}
    </span>
@endif
