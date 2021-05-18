@php
    /** @var array $post */
@endphp

<div class="social-links">
    <a href="https://www.reddit.com/submit?url={{ url()->current() }}&title={{ $post['title'] }}" target="_blank" rel="nofollow noopener noreferrer">
        <img data-src="{{ asset('storage/icons/reddit.png') }}" alt="reddit" class="smooth-loader">
    </a>
    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ url()->current() }}" target="_blank" rel="nofollow noopener noreferrer">
        <img data-src="{{ asset('storage/icons/linkedin.png') }}" alt="linked in" class="smooth-loader">
    </a>
    <a href="https://twitter.com/intent/tweet?text={{ $post['title'] }}&url={{ url()->current() }}" target="_blank" rel="nofollow noopener noreferrer">
        <img data-src="{{ asset('storage/icons/twitter.png') }}" alt="twitter" class="smooth-loader">
    </a>
    <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank" rel="nofollow noopener noreferrer">
        <img data-src="{{ asset('storage/icons/facebook.png') }}" alt="facebook" class="smooth-loader">
    </a>
</div>
