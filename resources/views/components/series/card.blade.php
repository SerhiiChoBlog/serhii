@php
    use App\Models\Series;

    /**
     * @var Series $series
     */
@endphp

<article class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-5 p-3 hover:bg-page-second rounded-lg transition-colors">
    <div>
        <img
            src="{{ asset($series->image_sm) }}"
            alt="{{ $series->title }}"
            class="w-full rounded-lg shadow-md"
            width="750"
            height="250"
        >

        <div class="flex flex-col gap-y-2 mt-2">
            <h2 class="text-xl lg:text-2xl font-bold">
                {{ $series->title }}
            </h2>

            <p class="text-gray-500">
                {!! $series->description !!}
            </p>
        </div>
    </div>

    <div>
        posts here
    </div>
</article>
