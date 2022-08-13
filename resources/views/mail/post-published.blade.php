@php
use App\Models\Post;

/**
 * @var Post $post
 */
@endphp

@component('mail::message')
<p style="margin-bottom: 0">New post is published:</p>
<h1>{{ $post->title }}</h1>
<img
    src="{{ $post->image_sm }}"
    alt="{{ $post->title }}"
    style="border-radius: 10px"
    width="550"
    height="275"
/>

<div>
</div>

@component('mail::button', ['url' => route('login')])
Read the post
@endcomponent

@endcomponent
