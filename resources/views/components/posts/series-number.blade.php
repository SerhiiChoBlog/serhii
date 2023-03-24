@php
    use App\Models\Post;

    /**
     * @var Post $post
     */

    $series_item = $post->series->first();
@endphp

@if ($series_item && $series_item->posts_count > 1)
    <a
        href="{{ route('series.show', $series_item->slug) }}"
        class="opacity-60 font-bold"
    >
        Part {{ $series_item->pivot->part }} of {{ $series_item->posts_count }}
    </a>
@endif
