@php
    use App\Models\Series;

    /**
     * @var Series $series
     */
@endphp

<div class="mb-4">
    <h2 class="text-2xl lg:text-3xl font-bold text-gray-100">
        {{ $series->title }}
    </h2>

    <h3 class="text-lg lg:text-xl text-main-light">
        {{ $series->intro }}
    </h3>

    <h4 class="text-md lg:text-lg text-gray-300">
        {{ $series->posts_count }} {{ str('article')->plural($series->posts_count) }}

        <x-edit-button
            url="/admin/series/{{ $series->id }}/edit"
            class="ml-2"
        />
    </h4>

    <h5 class="text-gray-300">{{ $series->read_time }} min total read time</h5>
</div>
