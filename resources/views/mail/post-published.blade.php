@php
use App\Models\Post;

/**
 * @var Post $post
 */
@endphp

@component('mail::message')
<p style="margin-bottom: 0">Hi, new post is published!</p>
<h1>{{ $post->title }}</h1>
<a href="{{ route('posts.show', $post) }}" target="_blank">
    <img
        src="{{ $post->image_sm }}"
        alt="{{ $post->title }}"
        style="border-radius: 10px"
        width="550"
        height="275"
    />
</a>

<div>
</div>

@component('mail::button', ['url' => route('posts.show', $post)])
Read the post
@endcomponent

@endcomponent
