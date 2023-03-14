@php
    use App\Models\Series;

    /**
     * @var Series $series
     */
@endphp

<article>
    <a href="{{ route('series.show', $series) }}" class="block">
        <img
            src="{{ $series->image_url }}"
            alt="{{ $series->title }}"
            class="w-full"
        >

        <div class="flex flex-col gap-y-2">
            <h2 class="text-xl font-bold">
                {{ $series->title }}
            </h2>

            <p class="text-gray-500">
                {!! $series->description !!}
            </p>
        </div>
    </a>
</article>
