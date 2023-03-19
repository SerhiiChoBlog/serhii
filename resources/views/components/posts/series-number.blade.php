@php
    use App\Models\Post;

    /**
     * @var Post $post
     */
@endphp
@if ($post->series->isNotEmpty())
    <a
        href="{{ route('series.show', $post->series->first()->slug) }}"
        class="opacity-60 font-bold"
    >
        Part {{ $post->series->first()->pivot->part }} of {{ $post->series->first()->posts_count }}
    </a>
@endif
