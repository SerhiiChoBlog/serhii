@php
    $classes = ($isDark ?? '') ? 'bg-page-second' : '';
@endphp

<section {{ $attributes->merge(['class' => "relative py-20 px-5 $classes"]) }}>
    <h2 class="pb-8 lg:pb-16 text-font-second text-3xl lg:text-4xl text-center">
        {{ $header }}
    </h2>

    <div class="container">
        {{ $slot }}
    </div>
</section>
