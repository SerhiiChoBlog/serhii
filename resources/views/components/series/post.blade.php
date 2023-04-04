@php
    use App\Models\Post;

    /**
     * @var Post $post
     */
@endphp

<tip content="{{ $post->is_published ? '' : 'Post is currently in progress' }}">
    <a
        href="{{ $post->is_published ? route('posts.show', $post->slug) : 'javascript:' }}"
        class="block transition-[outline] outline outline-transparent {{ $post->is_published ? 'hover:outline-main' : 'opacity-30 cursor-help' }} rounded-md"
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
</tip>
