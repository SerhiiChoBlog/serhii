<section class="py-12 px-5 {{ ($isDark ?? '') ? 'bg-page-second' : '' }}">
    <h2 class="pb-8 lg:pb-16 text-font-second text-3xl lg:text-4xl text-center">{{ $header }}</h2>

    <div class="container">
        {{ $slot }}
    </div>
</section>
