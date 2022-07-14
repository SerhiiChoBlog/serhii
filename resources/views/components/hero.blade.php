<header {{ $attributes->merge([]) }}>
    <div class="{{ $navbar ?? '' }}">
        <x-navbar />
    </div>

    <div class="{{ isset($title, $subtitle) ? 'px-5 pt-5 pb-12 lg:pt-10 lg:pb-20' : '' }}">
        <div class="text-center max-w-5xl mx-auto">
            @isset($title)
                <h1 class="text-2xl lg:text-3xl mb-2">{!! $title !!}</h1>
            @endisset

            @isset($subtitle)
                <h2 class="text-md lg:text-xl">{!! $subtitle !!}</h2>
            @endisset
        </div>

        {{ $slot ?? '' }}
    </div>
</header>
