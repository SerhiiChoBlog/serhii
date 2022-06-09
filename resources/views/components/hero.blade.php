<section {{ $attributes->merge(['class' => 'bg-gray-500']) }}>
    <div class="hero-head"><x-navbar /></div>

    <div class="p-[3em]">
        <div class="text-center font-lato">
            <h1 class="text-3xl mb-2">{{ $title }}</h1>
            <h2 class="text-[1.3em]">{!! $subtitle !!}</h2>
        </div>
    </div>
</section>
