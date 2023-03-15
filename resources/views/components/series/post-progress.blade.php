@php
    use App\Models\Series;

    /**
     * @var Series $series
     * @var int $part
     */
@endphp

<div class="w-full relative">
    <img
        src="{{ asset('storage/posts/placeholder-xs.jpg') }}"
        class="opacity-0"
        width="550"
        height="275"
        alt="Placeholder image"
        aria-hidden="true"
    />

    <div
        class="absolute inset-0 flex items-center justify-center bg-zinc-600 rounded-lg"
        style="background-color: {{ $series->color_from }}"
    >
        <div class="text-center text-gray-300">
            <h2 class="text-lg lg:text-2xl">Part {{ $part }}</h2>
            <h3 class="text-sm lg:text-lg -mt-1">In progress...</h3>
        </div>
    </div>
</div>
