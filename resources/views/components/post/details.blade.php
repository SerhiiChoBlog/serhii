@php
    /** @var array $post */
@endphp

<div class="opacity-70 flex items-center gap-5 {{ $attributes->get('class') }}">
    <time datetime="{{ $post['created_at'] }}">
        {{ $post['pretty_created_at'] }}
    </time>

    @if (isset($post['page_views_count']) && $post['page_views_count'] > 99)
        <span>{{ $post['page_views_count'] }} views</span>
    @endif

    @if (isset($post['read_time']) && $post['read_time'] > 0)
        <span>{{ $post['read_time'] }} minutes read</span>
    @endif
</div>
