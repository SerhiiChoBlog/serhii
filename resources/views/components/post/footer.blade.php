@php
    /** @var array $post */
@endphp

<div class="pb-6 pt-10 text-center flex flex-col text-2xl font-light text-font-second">
    <span>Thanks for your time!</span>
    <span>Please, share this post to support <a href="{{ route('about-me') }}" class="text-link hover:text-link-hover">the author</a></span>
</div>

<share-post-buttons post-title="{{ $post['title'] }}"
    :post-id="{{ $post['id'] }}"
    class="justify-center"
/>
