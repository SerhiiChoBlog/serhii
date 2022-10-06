<header {{ $attributes->merge([]) }}>
    <div class="{{ $navbar ?? '' }}">
        <x-navbar />
    </div>

    <div class="{{ isset($mainTitle, $subtitle) ? 'px-5 pt-5 pb-16 lg:pt-10 lg:pb-20' : '' }}">
        <div class="text-center max-w-5xl mx-auto">
            @isset($mainTitle)
                <h1 class="text-2xl lg:text-3xl mb-2">{!! $mainTitle !!}</h1>
            @endisset

            @isset($subtitle)
                <h2 class="text-md lg:text-xl">{!! $subtitle !!}</h2>
            @endisset
        </div>

        {{ $slot ?? '' }}
    </div>
</header>
