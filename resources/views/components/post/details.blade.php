@php
    use App\Models\Post;

    /**
     * @var Post $post
     */
@endphp

<div class="flex flex-wrap opacity-70 print:justify-center items-center gap-2.5 {{ $attributes->get('class') }}">
    <time aria-label="Post published date" datetime="{{ $post->updated_at }}" class="text-sm">
        {{ $post->pretty_updated_at }}
    </time>

    @if (isset($post->read_time) && $post->read_time > 0)
        <x-post.detail ariaLabel="Minutes to read">
            <x-icons.book class="w-4 h-4"/>
            {{ $post->read_time }} min
        </x-post.detail>
    @endif

    @if (isset($post->post_views_count) && $post->post_views_count > 0)
        <x-post.detail ariaLabel="Post views">
            <x-icons.views class="w-4 h-4"/>
            {{ $post->post_views_count }} views
        </x-post.detail>
    @endif

    @if (isset($post->comments_count) && $post->comments_count > 0)
        <x-post.detail ariaLabel="Post comments amount">
            <x-icons.comment class="w-4 h-4"/>
            {{ $post->comments_count }}
        </x-post.detail>
    @endif

    {{ $slot }}
</div>
