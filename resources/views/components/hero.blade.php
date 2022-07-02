<header {{ $attributes->merge([]) }}>
    <x-navbar />

    <div class="{{ isset($title, $subtitle) ? 'p-[1.5em] lg:p-[3em]' : '' }}">
        <div class="text-center max-w-5xl mx-auto">
            @isset($title)
                <h1 class="text-2xl lg:text-3xl mb-2">{!! $title !!}</h1>
            @endisset

            @isset($subtitle)
                <p class="text-md lg:text-xl">{!! $subtitle !!}</p>
            @endisset
        </div>

        {{ $slot ?? '' }}
    </div>
</header>
