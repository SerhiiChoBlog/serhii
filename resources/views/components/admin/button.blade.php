@php
    use Illuminate\View\ComponentAttributeBag;

    /**
     * @var ComponentAttributeBag $attributes
     */

    $classes = 'inline-block uppercase text-white text-sm px-6 py-2 rounded-full transition-all bg-main hover:bg-main-hover shadow-md hover:shadow-lg';
@endphp

@if ($attributes->has('href'))
    <a {{ $attributes->merge(['class' => $classes]) }}>
        <x-admin.spinner/>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes]) }}>
        <x-admin.spinner/>
        {{ $slot }}
    </button>
@endif
