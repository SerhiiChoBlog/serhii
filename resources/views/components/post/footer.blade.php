@php
    /** @var array $post */
@endphp

<a href="{{ route('about-me') }}"
   target="_blank"
    class="flex items-center justify-center gap-x-8 my-14"
>
    <div>
        <img data-src="{{ asset('storage/posts/thanks.jpeg') }}"
            alt="Serhii Cho"
            class="rounded-full shadow-md w-28"
            width="300"
            height="300"
        />
    </div>

    <div class="flex flex-col text-2xl font-light text-font-second">
        <span>Thanks for your time!</span>
        <span class="mb-4">Please, share this post to support me</span>
        <share-post-buttons post-title="{{ $post['title'] }}" :post-id="{{ $post['id'] }}" />
    </div>
</a>
