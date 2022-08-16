@php
use App\Models\Post;

/**
 * @var Post $post
 * @var string $unsubscribe
 * @var string $url
 * @var string $nice_url
 */
@endphp

@component('mail::layout')
@slot('header')
    @component('mail::header')
    @endcomponent
@endslot

<p style="margin-bottom: 2px">Hi, the new post is already published!</p>

<h1>{{ $post->title }}</h1>
<a href="{{ $url }}" target="_blank">
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
        <a href="{{ url('/') }}/posts?tag={{ $tag->name }}" aria-label="Filter posts by tag: {{ $tag->title }}">
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
<p>The read time is approximately <b>{{ $post->read_time }} minutes</b>.</p>

@component('mail::button', compact('url'))
Read the post
@endcomponent

@component('mail::subcopy')
    If you're having trouble clicking the button, copy and paste the URL into your web browser:
    <a href="{{ $url }}" target="_blank">{{ $nice_url }}</a>
@endcomponent

@slot('footer')
@component('mail::footer')
You are receiving this because you subscribed to new posts on {{ config('app.name') }}.
<br />
<a href="{{ $unsubscribe }}" target="_blank">Unsubscribe</a>
@endcomponent
@endslot

@endcomponent
