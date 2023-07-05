@php
    use Illuminate\View\ComponentAttributeBag;

    /**
     * @var string $header
     * @var string|null $subheader
     * @var string $classes
     * @var string $isDark
     * @var string $slot
     * @var ComponentAttributeBag $attributes
     */

    $classes = ($isDark ?? '') ? 'bg-page-second' : '';
@endphp

<section {{ $attributes->merge(['class' => "relative py-20 px-5 $classes"]) }}>
    <h2 class="text-font-second text-3xl lg:text-4xl text-center">
        {{ $header }}
    </h2>

    @isset($subheader)
        <h3 class="text-center mt-2 text-font-second">{{ $subheader }}</h3>
    @endisset

    <div class="container pt-8 lg:pt-16">
        {{ $slot }}
    </div>
</section>
