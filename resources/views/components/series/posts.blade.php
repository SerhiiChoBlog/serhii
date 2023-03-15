@php
    use App\Models\Series;

    /**
     * @var Series $series
     */
@endphp

<ul class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-1 gap-2">
    @foreach($series->posts as $post)
        <li>
            <x-series.post :post="$post"/>
        </li>
    @endforeach

    @for($part = $series->posts->count() + 1; $part <= $series->posts_count; $part++)
        <li>
            <x-series.post-progress
                :series="$series"
                :part="$part"
            />
        </li>
    @endfor
</ul>
