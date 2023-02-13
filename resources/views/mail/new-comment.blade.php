@php
use App\Models\Comment;

/**
 * @var Comment $comment
 */
@endphp

@component('mail::layout')
@slot('header')
    @component('mail::header')
    @endcomponent
@endslot

<h1>
    There is a new comment {{ $comment->is_approved ? 'published' : 'pending' }} for<br /> <b style="color: #5791c1;">{{ $comment->post->title }}</b>
</h1>

<div style="margin: 20px 0; display: flex; align-items: center; gap: 15px;">
<a href="{{ url('/@' . $comment->user->slug) }}" target="_blank">
<img src="{{ asset("storage/avatars/{$comment->user->avatar}") }}" width="50" height="50" style="border-radius: 50px;" />
</a>

<div>
    <h2 style="margin: 0;">{{ $comment->user->name }}</h2>
    <h3 style="margin: 0;">{{ $comment->user->email }}</h3>
</div>
</div>

<p style="font-style: italic; padding: 13px; border: 2px dashed #d5d5d5; border-radius: 10px;">
    {{ $comment->comment }}
</p>

<a href="{{ route('posts.show', $comment->post) }}" target="_blank">
    <img
        src="{{ url($comment->post->image_sm) }}"
        alt="{{ $comment->post->title }}"
        class="post-image"
        width="550"
        height="275"
    />
</a>

@component('mail::button', ['url' => url('/admin/comments')])
Admin panel
@endcomponent

@slot('footer')
@component('mail::footer')
@endcomponent
@endslot

@endcomponent
