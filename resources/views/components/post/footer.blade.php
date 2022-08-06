@php
    /** @var array $post */
@endphp

<div class="flex items-center justify-center gap-x-8 my-14">
    <a
        href="{{ route('about-me') }}"
        target="_blank"
        aria-label="To about me page"
        title="To about me page"
    >
        <img
            data-src="{{ asset('storage/posts/thanks.jpeg') }}"
            alt="Serhii Cho's photo"
            class="rounded-full shadow-md w-28"
            width="300"
            height="300"
        />
    </a>

    <div class="flex flex-col text-xl md:text-2xl font-light text-font-second">
        <span>Thanks for your time!</span>
        <span class="mb-4">Please, share this post to support me</span>
        <share-post-buttons post-title="{{ $post['title'] }}" :post-id="{{ $post['id'] }}" />
    </div>
</div>
