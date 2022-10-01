@php
    /** @var array $post */
@endphp

<div class="opacity-70 flex print:justify-center items-center gap-2 {{ $attributes->get('class') }}">
    <time datetime="{{ $post['created_at'] }}">
        {{ $post['pretty_created_at'] }}
    </time>

    <span aria-hidden="true">&#8226;</span>

    @if (isset($post['post_views_count']) && $post['post_views_count'] > 99)
        <span>{{ $post['post_views_count'] }} views</span>
        <span aria-hidden="true">&#8226;</span>
    @endif

    @if (isset($post['read_time']) && $post['read_time'] > 0)
        <span>{{ $post['read_time'] }} minutes read</span>
    @endif
</div>
