@php
    /** @var array $post */
@endphp

<div class="opacity-70 flex print:justify-center items-center gap-2 {{ $attributes->get('class') }}">
    <time datetime="{{ $post['created_at'] }}">
        {{ $post['pretty_created_at'] }}
    </time>

    <span aria-hidden="true">&#8226;</span>

    @if (isset($post['read_time']) && $post['read_time'] > 0)
        <span>{{ $post['read_time'] }} mins read</span>
    @endif
</div>
