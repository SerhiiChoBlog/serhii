@php
    use App\Models\Series;

    /**
     * @var Series $series
     */
@endphp

<article
    class="grid grid-cols-1 lg:grid-cols-[5fr_2fr] rounded-xl shadow-lg"
    style="background: linear-gradient(90deg, {{ $series->color_from }} 0%, {{ $series->color_to }} 100%)"
>
    <div class="p-4 lg:p-8 lg:pr-0 flex flex-col justify-between">
        <div>
            <x-series.header :series="$series" />

            <img
                src="{{ asset($series->image_xs) }}"
                data-src="{{ asset($series->image_sm) }}"
                alt="{{ $series->title }}"
                class="w-full rounded-lg shadow-md"
                width="750"
                height="250"
            >

            <div class="mt-4">
                <p class="text-md lg:text-lg text-gray-300 mt-3">
                    {!! $series->description !!}
                </p>
            </div>
        </div>

        <div class="text-right mt-3 lg:mt-7">
            <a
                href="{{ route('series.show', $series) }}"
                class="bg-page px-6 p-2 rounded-lg transition-opacity hover:opacity-80 inline-flex items-center gap-1"
            >
                <span>Read series</span>
                <x-icons.arrow-right class="w-6 h-6" />
            </a>
        </div>
    </div>

    <div class="border-t-4 lg:border-l-4 lg:border-t-0 border-dashed border-page p-4 lg:p-8 pl-4 ml-4 lg:pl-4">
        <x-series.posts :series="$series" />
    </div>
</article>
