<section {{ $attributes->merge(['class' => 'bg-gray-500']) }}>
    <x-navbar />

    <div class="p-[1.5em] lg:p-[3em]">
        <div class="text-center font-lato max-w-5xl mx-auto">
            <h1 class="text-2xl lg:text-3xl mb-2">{{ $title }}</h1>
            <h2 class="text-md lg:text-xl">{!! $subtitle !!}</h2>

            <div>
                {{ $slot ?? '' }}
            </div>
        </div>
    </div>
</section>
