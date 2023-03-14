@php
    use App\Models\Series;

    /**
     * @var Series $series
     */
@endphp

<div class="mb-4">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl lg:text-3xl font-bold text-gray-100">
            {{ $series->title }}
        </h2>

        <span class="text-md lg:text-lg text-gray-300">
            {{ $series->posts_count }} {{ str('article')->plural($series->posts_count) }}
        </span>
    </div>

    <h3 class="text-lg lg:text-xl text-main-light">
        {{ $series->intro }}
    </h3>
</div>
