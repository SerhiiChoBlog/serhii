<header {{ $attributes->merge(['class' => 'bg-gray-500']) }}>
    <x-navbar />

    <div class="p-[1.5em] lg:p-[3em]">
        <div class="text-center font-arizona max-w-5xl mx-auto">
            <h1 class="text-2xl lg:text-4xl mb-2">{{ $title }}</h1>
            <p class="text-md lg:text-xl">{!! $subtitle !!}</p>

            <div>
                {{ $slot ?? '' }}
            </div>
        </div>
    </div>
</header>
