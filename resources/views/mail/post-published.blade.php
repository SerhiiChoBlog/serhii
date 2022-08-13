@php
use App\Models\Post;

/**
 * @var Post $post
 */
@endphp

@component('mail::message')
<p style="margin-bottom: 2px">Hi, the new post is already published!</p>
<h1>{{ $post->title }}</h1>
<a href="{{ route('posts.show', $post) }}" target="_blank">
    <img
        src="{{ url($post->image_sm) }}"
        alt="{{ $post->title }}"
        class="post-image"
        width="550"
        height="275"
    />
</a>

<div class="tags">
    @foreach ($post->tags as $tag)
        <a href="/posts?tag={{ $tag->name }}" aria-label="Filter posts by tag: {{ $tag->title }}">
            <span
                class="tag"
                style="background-color: {{ $tag->color }}"
            >
                {{ $tag->name }}
            </span>
        </a>
    @endforeach
</div>

<p>{{ $post->intro }}</p>

@component('mail::button', ['url' => route('posts.show', $post)])
Read the post
@endcomponent

@endcomponent
