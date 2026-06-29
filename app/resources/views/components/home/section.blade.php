<section class="{{ $attributes->get('class') }} py-10 md:py-16 lg:py-24 {{ ($isDark ?? false) ? 'bg-page-second relative' : '' }}">
    @if ($isDark ?? false)
        <x-section-detail />
    @endif

    @isset($title)
        <h2 class="text-2xl font-bold text-font-second sm:text-3xl lg:text-4xl text-center lg:pb-2 px-3">
            {{ $title }}
        </h2>
    @endisset

    @isset($intro)
        <h3 class="text-lg lg:text-xl text-font-second sm:text-3xl text-center pb-8 lg:pb-12 opacity-90 px-3">
            {{ $intro }}
        </h3>
    @endisset

    <div class="container">
        {{ $slot }}
    </div>
</section>
