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
</ul>
