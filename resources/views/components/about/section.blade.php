@php
    use Illuminate\View\ComponentAttributeBag;

    /**
     * @var string $classes
     * @var string $isDark
     * @var string $slot
     * @var ComponentAttributeBag $attributes
     */

    $classes = ($isDark ?? '') ? 'bg-page-second' : '';
@endphp

<section {{ $attributes->merge(['class' => "relative py-10 px-5 $classes"]) }}>
    <div class="container pt-8 lg:pt-16">
        {{ $slot }}
    </div>
</section>
