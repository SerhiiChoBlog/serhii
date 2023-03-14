@php
    use App\Models\Post;

    /**
     * @var Post $post
     */
@endphp

<a
    href="{{ route('posts.show', $post->slug) }}"
    class="block"
>
    <img
        src="{{ asset($post->image_xs) }}"
        data-src="{{ asset($post->image_sm) }}"
        class="rounded-lg shadow-md shadow-md w-full"
        width="550"
        height="275"
        alt="Main image for the post '{{ $post->title }}'"
    />
</a>
