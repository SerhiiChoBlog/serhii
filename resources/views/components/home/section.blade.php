<section class="py-20 {{ ($isDark ?? false) ? 'bg-page-second relative' : '' }}">
    @if ($isDark ?? false)
        <x-section-detail />
    @endif

    @isset($title)
        <x-home.section-title>{{ $title }}</x-home.section-title>
    @endisset

    <div class="container">
        {{ $slot }}
    </div>
</section>
